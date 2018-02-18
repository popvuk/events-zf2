<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

class ResursTable
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
	
	public function getResurs($id_resurs)
	{
		$rowset = $this->tableGateway->select(array('id_resurs'=>$id_resurs));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function getResursByName($ime)
	{
		$rowset = $this->tableGateway->select(array('kontroler'=>$ime));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}

}
