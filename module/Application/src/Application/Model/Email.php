<?php
namespace Application\Model;

class Email {

	public $host; 
	public $port; 
	public $username; 
	public $password; 
	public $ssl_tls; 
	public $server_name;

	function exchangeArray($data)
	{
		$this->host = (isset($data['host'])) ? $data['host'] : null;
		$this->server_name = (isset($data['server_name'])) ? $data['server_name'] : null;
		$this->port = (isset($data['port'])) ? $data['port'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;
		$this->password = (isset($data['password'])) ? $data['password'] : null;
		$this->ssl_tls = (isset($data['ssl_tls'])) ? $data['ssl_tls'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}