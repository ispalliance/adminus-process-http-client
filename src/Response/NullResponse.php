<?php

namespace AdminusProcess\HttpClient\Response;

class NullResponse extends BaseResponse
{
	public function isSuccess()
	{
		return false;
	}
}