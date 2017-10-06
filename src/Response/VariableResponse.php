<?php

namespace AdminusProcess\HttpClient\Response;

class VariableResponse extends BaseResponse
{
	public function isSuccess()
	{
		if ($this->getStatusCode() === 200 && count($this->getData()) === 0) {
			return false;
		}

		return parent::isSuccess();
	}


	public function getMessage()
	{
		if ($this->getStatusCode() === 200 && count($this->getData()) === 0) {
			return "No task with that id was found";
		}

		return parent::getMessage();
	}


	public function getVariables()
	{
		$taskData = $this->getData();
		if (count($taskData) === 1) {
			if (array_key_exists("processInstance", $taskData[0])) {
				if (array_key_exists("variables", $taskData[0]["processInstance"])) {
					return $taskData[0]["processInstance"]["variables"];
				}
			}
		}

		return [];
	}
}