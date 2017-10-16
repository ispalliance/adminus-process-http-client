<?php

namespace AdminusProcess\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

abstract class BaseClient
{
	const GET = "GET";
	const POST = "POST";
	const DELETE = "POST";
	const PUT = "PUT";
	protected $config;
	protected $client;


	/**
	 * ProjectusClient constructor.
	 *
	 * @param ClientConfig $config
	 * @param Client $client
	 */
	public function __construct(ClientConfig $config, Client $client)
	{
		$this->config = $config;
		$this->client = $client;
	}


	protected function sendRequest($method, $uri, array $data = [])
	{
		try {
			$options = [
				'auth' => [$this->config->getUser(), $this->config->getPassword()]
			];
			if ($data) {
				$options["body"] = Utils::jsonEncode($data);
			}

			// Concat url with single slash
			$url = sprintf("%s/%s", $this->config->getBaseUrl(), ltrim($uri, "/"));

			$response = $this->client->request($method, $url, $options);
		}
		catch (ClientException $ex) {
			$response = $ex->getResponse();
		}
		catch (ServerException $ex) {
			$response = $ex->getResponse();
		}
		catch (\Exception $ex) {
			$response = null;
		}

		return $response;
	}
}