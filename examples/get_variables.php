<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;

$taskId = 426; //Task id from callback or ui

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");
	$client->checkConnection();
	$response = $client->getVariables($taskId);

	//Handle response
	if ($response->isSuccess()) {
		echo "Process has following variables: \n\n";
		$data = $response->getVariables();
		foreach ($data as $variableName => $value) {
			$typeOfValue = gettype($value);
			echo "$variableName = $value ($typeOfValue)\n";
		}
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}
