<?php

namespace AdminusProcess\HttpClient;

class UrlTranslator
{
	private $baseUrl;


	public function __construct($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}


	public function getDashboardTaskUrl($taskId)
	{
		return $this->baseUrl . "?route=/dashboard/task/$taskId";
	}


	public function getInboxTaskUrl($taskId)
	{
		return $this->baseUrl . "?route=/inbox/task/$taskId";
	}
}