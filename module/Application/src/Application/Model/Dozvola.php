<?php
namespace Application\Model;

class Dozvola {

	public $id_dozvola;
	public $id_rola;
	public $id_resurs;

	function exchangeArray($data)
	{
		$this->id_dozvola = (isset($data['id_dozvola'])) ? $data['id_dozvola'] : null;
		$this->id_rola = (isset($data['id_rola'])) ? $data['id_rola'] : null; //ako nije setovan onda je null
		$this->id_resurs = (isset($data['id_resurs'])) ? $data['id_resurs'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}