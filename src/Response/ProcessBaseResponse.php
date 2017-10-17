<?php

namespace AdminusProcess\HttpClient\Response;

use AdminusProcess\HttpClient\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface;

abstract class ProcessBaseResponse extends BaseResponse
{
	public static function from(ResponseInterface $psr7Response = null)
	{
		$response = parent::from($psr7Response);
		$headerLine = "";
		if ($psr7Response) {
			$headerLine = $psr7Response->getHeaderLine("X-PROJECTUS");
		}
		if (!in_array($headerLine, ["OK"])) {
			throw new RuntimeException("The response from server is not valid");
		}

		return $response;
	}
}