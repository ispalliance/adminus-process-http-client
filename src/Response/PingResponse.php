<?php

namespace AdminusProcess\HttpClient\Response;

class PingResponse extends BaseResponse
{
	public function isSuccess()
	{
		return $this->getStatusCode() === 200;
	}


	public function getApplicationName()
	{
		return $this->safeGetFromData("applicationName");
	}


	public function getApplicationVersion()
	{
		return $this->safeGetFromData("applicationVersion");
	}


	public function getApiVersion()
	{
		return $this->safeGetFromData("apiVersion");
	}


	public function getApiName()
	{
		return $this->safeGetFromData("apiName");
	}


	private function safeGetFromData($name)
	{
		$data = $this->getData();
		if ($data && is_array($data) && array_key_exists($name, $data)) {
			return $data[$name];
		}

		return null;
	}
}