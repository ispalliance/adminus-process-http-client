<?php

require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;
use AdminusProcess\HttpClient\Request\TaskQueryRequest;

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");

	//Create request with variable quuery
	$query = new TaskQueryRequest();
	$query->filter()->variable("typ_faktury")->equal('zbozi');

	$response = $client->findTaskByQuery($query);

	//Handle response
	if ($response->isSuccess()) {
		foreach ($response->getTasks() as $task) {
			echo "Following tasks are listed: \n";
			echo "{$task['id']}-{$task['name']} \n";
		}
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}