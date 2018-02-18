<?php
 namespace Application\Model;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Sql;
 use Zend\Db\ResultSet\ResultSet;

 class PostTable 
 {

    protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getPostsByKorime($korime)
	{
	    $uslov = array('korime'=>$korime, 'flag'=>1);
	     
	    $sql = new Sql($this->tableGateway->adapter);
	    $select = $sql->select();
	    $select -> from ( $this->tableGateway->getTable() )
	            -> join ( 'korisnik' , 'korisnik.id=post.id_korisnik')
	            -> join ( 'kategorija', 'kategorija.id_kat=post.id_kat')
	            -> order( 'dat_objave DESC');
	            
	    if($korime != null)
	    {
	        $select->where($uslov);
	    }
	    else 
	    {
	        $select->where(array('flag'=>1));
	    }
	    $statement = $sql->prepareStatementForSqlObject($select);
	    $result = $statement->execute();
	
	    $resultset = new ResultSet();
	    $resultset->initialize($result);
	     
	    return $resultset;
	}
	
	public function getPostById($id)
	{
	    $uslov = array('id_post'=>$id);
	
	    $sql = new Sql($this->tableGateway->adapter);
	    $select = $sql->select();
	    $select -> from ( $this->tableGateway->getTable() )
	            -> join ( 'korisnik' , 'korisnik.id=post.id_korisnik')
	            -> join ( 'kategorija', 'kategorija.id_kat=post.id_kat')
	            -> where( $uslov);

	    $statement = $sql->prepareStatementForSqlObject($select);
	    $result = $statement->execute();
	
	    $resultset = new ResultSet();
	    $resultset->initialize($result);
	
	    return $resultset->current();
	}
	
    public function getWaitingPosts()
	{
	    $uslov = array('flag'=>0);
	     
	    $sql = new Sql($this->tableGateway->adapter);
	    $select = $sql->select();
	    $select -> from ( $this->tableGateway->getTable() )
	            -> join ( 'korisnik' , 'korisnik.id=post.id_korisnik')
	            -> join ( 'kategorija', 'kategorija.id_kat=post.id_kat')
	            -> order( 'dat_objave DESC');
	            
	    $select->where($uslov);
	  
	    $statement = $sql->prepareStatementForSqlObject($select);
	    $result = $statement->execute();
	
	    $resultset = new ResultSet();
	    $resultset->initialize($result);
	     
	    return $resultset;
	}
	
	public function getPostsByKat($kat)
	{
	    $uslov = array('post.id_kat'=>$kat, 'flag'=>1);
	
	    $sql = new Sql($this->tableGateway->adapter);
	    $select = $sql->select();
	    $select -> from ( $this->tableGateway->getTable() )
	            -> join ( 'korisnik' , 'korisnik.id=post.id_korisnik')
	            -> join ( 'kategorija', 'kategorija.id_kat=post.id_kat')
	            -> order( 'dat_objave DESC');
	    $select-> where( $uslov);
	
	    $statement = $sql->prepareStatementForSqlObject($select);
	    $result = $statement->execute();
	
	    $resultset = new ResultSet();
	    $resultset->initialize($result);
	
	    return $resultset;
	}
	
	public function getPostsById($id)
	{
	    $rowset = $this->tableGateway->select(array('id_korisnik' => $id));
		
		return $rowset;
	}
	
	public function createPost(Post $post)
	{
	    $data = array(
	        'id_korisnik'=>$post->id_korisnik,
	        'id_kat'=>$post->id_kat,
	        'naslov'=>$post->naslov,
	        'dat_objave' =>$post->dat_objave,
	        'dat_od' =>$post->dat_od,
	        'dat_do' =>$post->dat_do,
	        'vreme' => $post->vreme,
	        'lokacija' =>$post->lokacija,
	        'slika' =>$post->slika,
	        'tekst' =>$post->tekst,
	    );
	    $this->tableGateway->insert($data);
	    
	    return $this->tableGateway->lastInsertValue;
	}
	
	public function editPost($slika, $id_posta)
	{
	    $data = array(
	        'slika'=>$slika,
	    );
	    $this->tableGateway->update($data, array('id_post' => $id_posta));
	}
     
	public function updatePost($id)
	{
	    $data = array(
	        'flag'=>1,
	    );
	    $this->tableGateway->update($data, array('id_post' => $id));
	
	}
	
	public function deletePost($id)
	{
	    $this->tableGateway->delete(array('id_post' => $id));
	}
	
	public function delPostByKat($id)
	{
	    $this->tableGateway->delete(array('id_kat' => $id));
	}
	
	public function getDelPosts($id)
	{
	    $resultset =  $this->tableGateway->select(array('id_kat' => $id));
	    return $resultset;
	}
	
	
	
}