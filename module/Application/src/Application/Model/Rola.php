<?php
namespace Application\Model;

class Rola {

	public $id_rola;
	public $naziv_rola;

	function exchangeArray($data)
	{
		$this->id_rola = (isset($data['id_rola'])) ? $data['id_rola'] : null; 
		$this->naziv_rola = (isset($data['naziv_rola'])) ? $data['naziv_rola'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}