<?php

namespace AdminusProcess\HttpClient\Request;

use AdminusProcess\HttpClient\Exception\InvalidArgumentException;

class TaskQueryRequest extends BaseRequest
{
	/** @var TaskQueryFilterBuilder[] */
	private $filters = [];


	/**
	 * @internal
	 *
	 * @param array $filter filter array for request do not construct this by hand request will fail
	 */
	public function addFilter(array $filter)
	{
		$data["filter"][] = $filter;
	}


	public function filter()
	{
		if (count($this->filters) > 0) {
			throw new InvalidArgumentException("Use andFilter or orFilter method you already have filter inplace");
		}

		$filter = new TaskQueryFilterBuilder(null, $this);
		$this->filters[] = $filter;

		return $filter;
	}


	public function andFilter()
	{
		if (count($this->filters) === 0) {
			throw new InvalidArgumentException("Use filter method at first place");
		}

		$filter = new TaskQueryFilterBuilder("AND", $this);
		$this->filters[] = $filter;

		return $filter;
	}


	public function orFilter()
	{
		if (count($this->filters) === 0) {
			throw new InvalidArgumentException("Use filter method at first place");
		}

		$filter = new TaskQueryFilterBuilder("OR", $this);
		$this->filters[] = $filter;

		return $filter;
	}


	public function getData()
	{
		$data = [];
		foreach ($this->filters as $filter) {
			$data[] = $filter->getFilter();
		}
		return $data;
	}
}