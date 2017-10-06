<?php

namespace AdminusProcess\HttpClient\Response;

class TaskResponse extends BaseResponse
{
	public function getTask()
	{
		return $this->getData();
	}
}