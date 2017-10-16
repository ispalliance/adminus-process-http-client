<?php

namespace AdminusProcess\HttpClient;

use AdminusProcess\HttpClient\Exception\InvalidArgumentException;
use AdminusProcess\HttpClient\Request\TaskQueryRequest;
use AdminusProcess\HttpClient\Response\TaskListResponse;
use AdminusProcess\HttpClient\Response\TaskResponse;
use AdminusProcess\HttpClient\Response\VariableResponse;

/**
 * Class for connecting to projectus
 */
final class ProcessClient extends BaseClient
{
	/**
	 * Returns information about server
	 *
	 * @param $processId
	 * @param array $forms assoc array with formId mapped to assoc array with property and value
	 *
	 * @return TaskResponse
	 */
	public function startProcess($processId, $forms = [])
	{

		$data = [
			"item" => [
				"processInstance" => ["id" => $processId],
				"hash" => uniqid(),
			],
			"forms" => $forms
		];
		$response = $this->sendRequest(self::POST, "/task-repository", $data);

		return TaskResponse::from($response);
	}


	/**
	 * Returns information about server
	 *
	 * @param $query
	 *
	 * @return TaskListResponse
	 *
	 */
	public function findTaskByQuery(TaskQueryRequest $query)
	{
		$response = $this->sendRequest(self::POST, "/task-repository/query-request", $query->getData());

		return TaskListResponse::from($response);
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


	/**
	 * Creature url translator for current projectus instance
	 *
	 * @return UrlTranslator
	 */
	public function getUrlTranslator()
	{
		return new UrlTranslator($this->config->getWebBaseUrl());
	}
}