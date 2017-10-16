<?php

namespace AdminusProcess\HttpClient;

/*
 * @param string $url Projectus endpoint e.g. http://app.projectus.cz/ or http://projectus.ispa.cz/
	 * @param string $user User name
	 * @param string $pass Password
 */

class ClientConfig
{
	/** @var string */
	private $url;
	/** @var string */
	private $user;
	/** @var string */
	private $password;


	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}


	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}


	public function getBaseUrl()
	{
		return $this->url . "/rest/projectus";
	}


	public function getWebBaseUrl()
	{
		return $this->url . "/projectus";
	}


	/**
	 * @return string
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * @param string $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}


	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}


	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}
}