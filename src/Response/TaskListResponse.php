<?php

namespace AdminusProcess\HttpClient\Response;

class TaskListResponse extends BaseResponse
{
	public function getTasks()
	{
		return $this->getData();
	}
}