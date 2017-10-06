<?php

namespace AdminusProcess\HttpClient;

class Utils
{
	public static function jsonEncode($data)
	{
		return \GuzzleHttp\json_encode($data);
	}


	public static function jsonDecode($data, $assoc = false)
	{
		return \GuzzleHttp\json_decode($data, $assoc);
	}
}