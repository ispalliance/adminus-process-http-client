<?php

namespace AdminusProcess\HttpClient;

use GuzzleHttp\Client;

class ProcessClientFactory
{
	/**
	 * Creates process client
	 *
	 * @param string $url
	 * @param string $user
	 * @param string $password
	 *
	 * @return ProcessClient
	 */
	public static function create($url, $user, $password)
	{
		$guzzle = new Client([
			"verify" => false
		]);
		$config = new ClientConfig();
		$config->setUrl($url);
		$config->setUser($user);
		$config->setPassword($password);

		return new ProcessClient($config, $guzzle);
	}
}