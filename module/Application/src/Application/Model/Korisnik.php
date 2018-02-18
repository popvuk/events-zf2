<?php

namespace Application\Model;

class Korisnik 
{
	
		public $id;
		public $korime;
		public $sifra;
		public $ime;
		public $prezime;
		public $email;
		public $rola;
	
		function exchangeArray($data)
		{
			$this->id = (isset($data['id'])) ? $data['id'] : null; 
			$this->korime = (isset($data['korime'])) ? $data['korime'] : null;
			$this->ime = (isset($data['ime'])) ? $data['ime'] : null;
			$this->prezime = (isset($data['prezime'])) ? $data['prezime'] : null;
			$this->email = (isset($data['email'])) ? $data['email'] : null;
			$this->rola = (isset($data['rola'])) ? $data['rola'] : null;
			if (isset($data['sifra']))
			{
			    $this->setPassword($data['sifra']);
			}
		
		}
		
		public function setPassword($clear_password)
		{
		    $this->sifra = md5($clear_password);
		}
		
		public function getArrayCopy()
		{
			return get_object_vars($this);
		}
	
}
