<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;

$taskId = 426; // Task id from callback or ui

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");
	$client->checkConnection();
	$response = $client->next($taskId);

	//Handle response
	if ($response->isSuccess()) {
		echo "Process in moved to next state: \n";
		echo $response->getTask()['id'] . "\n";
		echo $response->getTask()['name'] . "\n";
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}