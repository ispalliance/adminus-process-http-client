<?php

/**
 *
 * Helper class for TaskQueryRequest do not use directly
 *
 * @internal
 */
class TaskQueryFilterBuilder
{
	private $filter = [];
	private $operatorsSupported = [
		"EQUAL" => ["name", "variable", "state", "expiration"],
		"NOT_EQUAL" => ["name", "variable", "state", "expiration"],
		"LIKE" => ["name"],
		"BEFORE" => ["expiration"],
		"AFTER" => ["expiration"],
	];
	/**
	 *
	 */
	private $taskQueryRequest;


	/**
	 * TaskQueryFilterBuilder constructor.
	 * @internal
	 *
	 * @param string $type can be OR AND
	 * @param TaskQueryRequest $taskQueryRequest
	 */
	public function __construct($type = null, TaskQueryRequest $taskQueryRequest)
	{
		if (!in_array($type, ["OR", "AND"])) {
			throw new InvalidArgumentException("Supported type as AND, OR");
		}
		$this->filter["type"] = $type;
		$this->taskQueryRequest = $taskQueryRequest;
	}


	public function variable($name)
	{
		$this->filter["property"] = "variable";
		$this->filter["variable"] = $name;

		return $this;
	}


	public function name()
	{
		$this->filter["property"] = "name";

		return $this;
	}


	public function state()
	{
		$this->filter["property"] = "state";

		return $this;
	}


	public function expiration()
	{
		$this->filter["property"] = "expiration";

		return $this;
	}


	public function equal($value)
	{
		$this->filter["operator"] = "EQUAL";
		$this->filter["value"] = $value;

		$this->checkSupportedOperators($this->filter["property"], $this->filter["operator"]);

		return $this->taskQueryRequest;
	}


	public function notEqual($value)
	{
		$this->filter["operator"] = "NOT_EQUAL";
		$this->filter["value"] = $value;

		$this->checkSupportedOperators($this->filter["property"], $this->filter["operator"]);

		return $this->taskQueryRequest;
	}


	public function like($value)
	{
		$this->filter["operator"] = "LIKE";
		$this->filter["value"] = $value;

		$this->checkSupportedOperators($this->filter["property"], $this->filter["operator"]);

		return $this->taskQueryRequest;
	}


	public function before($value)
	{
		$this->filter["operator"] = "BEFORE";
		$this->filter["value"] = $value;

		$this->checkSupportedOperators($this->filter["property"], $this->filter["operator"]);

		return $this->taskQueryRequest;
	}


	public function after($value)
	{
		$this->filter["operator"] = "AFTER";
		$this->filter["value"] = $value;

		$this->checkSupportedOperators($this->filter["property"], $this->filter["operator"]);

		return $this->taskQueryRequest;
	}


	private function checkSupportedOperators($name, $operator)
	{
		if (!array_key_exists($operator, $this->operatorsSupported)) {
			throw new InvalidArgumentException("Operator $operator not exists");
		}
		if (!in_array($name, $this->operatorsSupported[$operator])) {
			throw new InvalidArgumentException("Operator $operator not supported for $name");
		}
	}


	public function getFilter()
	{
		return $this->filter;
	}
}
