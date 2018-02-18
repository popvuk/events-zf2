<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

class KategorijaTable
{

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	public function createKat($kat)
	{
	    $data = array(
	        'naziv_kat'=>$kat->naziv_kat,
	    );
	    $resultSet = $this->tableGateway->insert($data);
	}
	
	public function deleteKat($id)
	{
	    $this->tableGateway->delete(array('id_kat'=>$id)); 
	}
	
}

