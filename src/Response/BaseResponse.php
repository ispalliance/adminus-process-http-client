<?php

namespace AdminusProcess\HttpClient\Response;

use AdminusProcess\HttpClient\Utils;
use Psr\Http\Message\ResponseInterface;

abstract class BaseResponse
{
	/** @var array|null */
	protected $body;
	/** @var ResponseInterface|null */
	protected $psr7Response;


	/**
	 * Response constructor.
	 *
	 * @param null|ResponseInterface $psr7Response
	 */
	protected function __construct(ResponseInterface $psr7Response = null)
	{
		$this->psr7Response = $psr7Response;
	}


	/**
	 * Creates projectus response from PSR7 response interface of guzzle
	 *
	 * @param ResponseInterface $psr7Response
	 *
	 * @return static
	 */
	public static function from(ResponseInterface $psr7Response = null)
	{
		if ($psr7Response === null) {
			return new NullResponse(null);
		}
		$response = new static($psr7Response);
		$headerLine = $psr7Response->getHeaderLine("Content-Type");
		if (in_array($headerLine, ["application/json", "application/json; charset=utf-8"])) {
			$jsonString = $psr7Response->getBody()->getContents();
			try {
				$response->body = Utils::jsonDecode($jsonString, true);
			}
			catch (\Exception $ex) {
				//do nothing
			}
		}

		return $response;
	}


	/**
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->getStatusCode() === 200
			&& $this->body !== null
			&& array_key_exists("data", $this->body)
			&& array_key_exists("message", $this->body);
	}


	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->psr7Response ? $this->psr7Response->getStatusCode() : 0;
	}


	/**
	 * @return array
	 */
	public function getBody()
	{
		return $this->body;
	}


	/**
	 * @return null|ResponseInterface
	 */
	public function getPsr7Response()
	{
		return $this->psr7Response;
	}


	public function getMessage()
	{
		$code = $this->getStatusCode();
		if ($code !== 400) {
			if (is_array($this->body) && array_key_exists("message", $this->body)) {
				return $this->body["message"];
			}
		}
		else {
			if (is_array($this->body)
				&& array_key_exists("data", $this->body)
				&& array_key_exists("error", $this->body["data"])) {
				return $this->body["data"]["error"];
			}
		}

		return "Cannot parse message from body";
	}


	public function getData()
	{
		if (is_array($this->body) && array_key_exists("data", $this->body)) {
			return $this->body["data"];
		}

		return null;
	}
}