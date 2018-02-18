<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class KomentarTable
{

    protected $tableGateway;
 

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getKomByPost($id_post)
    {
        $resultset = $this->tableGateway->select(array('id_post'=>$id_post));
        return $resultset;
    }
    
    public function createKomentar(Komentar $komentar)
    {
        $data = array(
            'id_post'=>$komentar->id_post,
            'korime' =>$komentar->korime,
            'komentar' =>$komentar->komentar
        );
        
        $this->tableGateway->insert($data);
    }
    
    public function delKomByKor($korime)
    {
        $this->tableGateway->delete(array('korime'=>$korime)); 
    }
    
    public function delKomByPost($id)
    {
        $this->tableGateway->delete(array('id_post'=>$id));
    }
    
    public function delKomentar($id)
    {
        $this->tableGateway->delete(array('id_kom'=>$id));
    }
    
    public function getKomById($id_kom)
    {
        $rowset = $this->tableGateway->select(array('id_kom'=>$id_kom));
        $row = $rowset->current(); 
		if (!$row) {
			throw new \Exception("Could not find database row ");
		}
		return $row;
    }
}