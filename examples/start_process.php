<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;

$processId = 8;

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://master-projectus.jrh/", "root", "pass");
	$response = $client->startProcess($processId, [], "start", "user@example.com");
	var_dump($response->getBody());
	//Handle response
	if ($response->isSuccess()) {
		echo "Process started: \n";
		echo "Task ID: " . $response->getTask()['id'] . "\n";
		echo "Task Name: " . $response->getTask()['name'] . "\n";
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
		if ($response->getStatusCode() == 400) {
			$data = $response->getData();
			if ($data !== null) {
				foreach ($data as $formId => $errors) {
					echo "Form with id $formId:\n";
					if (is_array($errors)) {
						foreach ($errors as $name => $error) {
							echo "Field '$name': $error";
						}
					}
					echo "\n";
				}
			}
		}
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}