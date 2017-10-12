<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;
use AdminusProcess\HttpClient\Request\TaskQueryRequest;

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");
	$client->checkConnection();

	//Create request with variable quuery
	$query = new TaskQueryRequest();
	$query
		->filter()->variable("customer_id")->equal(14)
		->andFilter()->variable("task_creator")->equal("adminus");

	$response = $client->findTaskByQuery($query);

	//Handle response
	if ($response->isSuccess()) {
		echo "Following tasks are listed: \n";
		echo $response->getTasks()['id'] . "\n";
		echo $response->getTasks()['name'] . "\n";
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}