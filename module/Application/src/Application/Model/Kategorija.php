<?php
namespace Application\Model;

class Kategorija {

	public $id_kat;
	public $naziv_kat;

	function exchangeArray($data)
	{
		$this->id_kat = (isset($data['id_kat'])) ? $data['id_kat'] : null; 
		$this->naziv_kat = (isset($data['naziv_kat'])) ? $data['naziv_kat'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}