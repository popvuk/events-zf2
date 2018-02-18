<?php
namespace Application\Model;

class Resurs {

	public $id_resurs;
	public $naziv_resursa;
	public $kontroler;

	function exchangeArray($data)
	{
		$this->id_resurs = (isset($data['id_resurs'])) ? $data['id_resurs'] : null; 
		$this->naziv_resursa = (isset($data['naziv_resursa'])) ? $data['naziv_resursa'] : null;
		$this->kontroler = (isset($data['kontroler'])) ? $data['kontroler'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}