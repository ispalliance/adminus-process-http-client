<?php
if(function_exists('xdebug_disable')) { xdebug_disable(); }
require __DIR__ . "/../vendor/autoload.php";

use AdminusProcess\HttpClient\ProcessClientFactory;

$taskId = 426; //Task id usually by callback integration or manually from ui
$formId = 2; //Form id you can see it in the ui

try {
	//Create client send request
	$client = ProcessClientFactory::create("http://projectus.dev/", "root", "pass");
	$client->checkConnection();
	$response = $client->fillForm($taskId, $formId, ["schvaleni" => "ano"]);

	//Handle response
	if ($response->isSuccess()) {
		$task = $response->getTask();
		echo "Form process step in step was filled: {$task['id']} - {$task['name']}\n";
	}
	else {
		echo "{$response->getStatusCode()}:{$response->getMessage()}\n";
	}
}
catch (RuntimeException $ex) {
	echo $ex->getMessage();
}

