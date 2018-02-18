<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class KorisnikTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function createKorisnik(Korisnik $user)
	{
		$data = array(
				'korime' => $user->korime,
				'sifra' =>$user->sifra,
				'ime' =>$user->ime,
				'prezime' =>$user->prezime,
				'email' => $user->email,
				'rola' => '2',
		    );
		
			$this->tableGateway->insert($data);			
	}
	
	public function getKorisnik($id)
	{
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current(); 
		if (!$row) {
			throw new \Exception("Could not find row ");
		}
		return $row;
	}
	
	public function getKorisnikByEmail($email)
	{
	    $rowset = $this->tableGateway->select(array('email' => $email));
	    $row = $rowset->current();
	    if (!$row) {
	        throw new \Exception("Could not find row ");
	    }
	    return $row;
	}
	
	public function getKorisnikByKorime($korime)
	{
	    $uslov = array('korime'=>$korime);
	    
	    $sql = new Sql($this->tableGateway->adapter);
	    $select = $sql->select();
	    $select -> from ( $this->tableGateway->getTable() )
	            -> join ( 'rola' , 'rola.id_rola=korisnik.rola')
	            -> where( $uslov);

	    $statement = $sql->prepareStatementForSqlObject($select);
	    $result = $statement->execute();
	    	
	    $resultset = new ResultSet();
	    $resultset->initialize($result);
	    
	    return $resultset->current();
	}
	
	
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();

		return $resultSet;
	}
	
	public function deleteKor($id)
	{
	    $resultSet = $this->tableGateway->delete(array('id'=>$id));
	}

}

