<?php

namespace AdminusProcess\HttpClient;

use AdminusProcess\HttpClient\Exception\InvalidArgumentException;
use AdminusProcess\HttpClient\Exception\RuntimeException;
use AdminusProcess\HttpClient\Response\PingResponse;
use AdminusProcess\HttpClient\Response\TaskResponse;
use AdminusProcess\HttpClient\Response\VariableResponse;

/**
 * Class for connecting to projectus
 */
final class ProcessClient extends BaseClient
{
	const SUPPORTED_VERSION = ["v1"];


	/**
	 * Returns information about server
	 *
	 * @return PingResponse
	 */
	public function ping()
	{
		$response = $this->sendRequest(self::GET, "/ping");

		return PingResponse::from($response);
	}


	/**
	 * Fill in form
	 *
	 * @param int $taskId Task id is usually sent by callback
	 * @param int $formId Form id is usually sent by callback
	 * @param array $data Flatt array with data e.g. ["name" => "Jan", "surname" => "Novak", "age" => 30]
	 *
	 * @return TaskResponse
	 */
	public function fillForm($taskId, $formId, array $data)
	{
		if (!is_int($taskId)) {
			throw new InvalidArgumentException("TaskId must be integer got: '$taskId'");
		}
		if (!is_int($formId)) {
			throw new InvalidArgumentException("FormId must be integer got: '$formId'");
		}

		$response = $this->sendRequest(self::POST, "/form-service/form/{$formId}/task/{$taskId}", $data);

		return TaskResponse::from($response);
	}


	/**
	 * Set state of the task to next step
	 *
	 * @param $taskId
	 *
	 * @return TaskResponse
	 */
	public function next($taskId)
	{
		if (!is_int($taskId)) {
			throw new InvalidArgumentException("TaskId must be integer got: '$taskId'");
		}

		$response = $this->sendRequest(self::POST, "/process-service/next/{$taskId}");

		return TaskResponse::from($response);
	}


	/**
	 * Set state of the task to next step
	 *
	 * @param $taskId
	 *
	 * @return VariableResponse
	 */
	public function getVariables($taskId)
	{
		if (!is_int($taskId)) {
			throw new InvalidArgumentException("TaskId must be integer got: '$taskId'");
		}

		$query = Utils::jsonEncode(["filter" => [["property" => "id", "value" => $taskId]]]);
		$response = $this->sendRequest(self::GET, "/task-repository/query/?query={$query}");

		return VariableResponse::from($response);
	}


	public function checkConnection()
	{
		$response = $this->ping();
		if (!$response->isSuccess()) {
			throw new RuntimeException("Cannot connect to server");
		}
		if ($response->getApiName() !== "projectus") {
			throw new RuntimeException("The url is not adminus process api endpoint");
		}
		if (!in_array($response->getApiVersion(), self::SUPPORTED_VERSION)) {
			throw new RuntimeException("Unsupported api version: " . $response->getApplicationVersion());
		}
	}
}