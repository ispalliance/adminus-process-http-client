<?php

namespace AdminusProcess\HttpClient\Response;

class TaskResponse extends ProcessBaseResponse
{
	public function getTask()
	{
		return $this->getData();
	}
}