<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;


class DozvolaTable 
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
	
	public function getDozvole($id_rola)
	{
		$rowset = $this->tableGateway->select(array('id_rola'=>(int) $id_rola));		
		return $rowset;
	}
	
	public function deleteDozvole($id_rola)
	{
		$this->tableGateway->delete(array('id_rola' =>(int) $id_rola));
	}
	
	public function addDozvola($rola, $resurs)//proverava usera na osnovu ID-a
	{
		$data = array(
				'id_rola'=>$rola,
				'id_resurs'=>$resurs,
		);
		$this->tableGateway->insert($data);
	
	}
}