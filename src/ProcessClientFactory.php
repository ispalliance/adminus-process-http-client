<?php

namespace AdminusProcess\HttpClient;

use GuzzleHttp\Client;

class ProcessClientFactory
{
	public static function create($url, $user, $password)
	{
		$guzzle = new Client();
		$config = new ClientConfig();
		$config->setUrl($url);
		$config->setUser($user);
		$config->setPassword($password);

		return new ProcessClient($config, $guzzle);
	}
}