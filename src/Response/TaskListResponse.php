<?php

namespace AdminusProcess\HttpClient\Response;

class TaskListResponse extends ProcessBaseResponse
{
	public function getTasks()
	{
		return $this->getData();
	}
}