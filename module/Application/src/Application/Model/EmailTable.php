<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

class EmailTable
{

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetch()
	{
		$resultSet = $this->tableGateway->select();
		$result = $resultSet->current();
		return $result;
	}
	
	public function updateEmail(Email $email)
	{
		$data = array(
	            'host'=>$email->host,
				'server_name'=>$email->server_name,
				'port'=>$email->port,
				'username'=>$email->username,
				'password'=>$email->password,
				'ssl_tls'=>$email->ssl_tls,
		);
		$this->tableGateway->update($data);
	}
	

}
