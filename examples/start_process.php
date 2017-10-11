<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;

$processId = 16;

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");
	$client->checkConnection();
	$response = $client->startProcess($processId);

	//Handle response
	if ($response->isSuccess()) {
		echo "Process started: \n";
		echo "Task ID: ". $response->getTask()['id'] . "\n";
		echo "Task Name" . $response->getTask()['name'] . "\n";
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
		if ($response->getStatusCode() == 400) {
			$data = $response->getData();
			if ($data !== null) {
				foreach ($data as $formId => $errors) {
					echo "Form with id $formId:\n";
					foreach ($errors as $name => $error) {
						echo "Field '$name': $error";
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