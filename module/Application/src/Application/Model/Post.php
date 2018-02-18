<?php

namespace Application\Model;

class Post {
	
		public $id_post, $id_korisnik, $id_kat, $naslov, $dat_objave;
		public $dat_od, $dat_do, $vreme, $lokacija, $tekst, $slika, $flag;
	
		function exchangeArray($data)
		{
			$this->id_post = (isset($data['id_post'])) ? $data['id_post'] : null; 
			$this->id_korisnik = (isset($data['id_korisnik'])) ? $data['id_korisnik'] : null;
			$this->id_kat = (isset($data['id_kat'])) ? $data['id_kat'] : null;
			$this->naslov = (isset($data['naslov'])) ? $data['naslov'] : null;
			$this->dat_objave = (isset($data['dat_objave'])) ? $data['dat_objave'] : null;
			$this->dat_od = (isset($data['dat_od'])) ? $data['dat_od'] : null;
			$this->dat_do = (isset($data['dat_do'])) ? $data['dat_do'] : null;
			$this->vreme = (isset($data['vreme'])) ? $data['vreme'] : null;
			$this->lokacija = (isset($data['lokacija'])) ? $data['lokacija'] : null;
			$this->tekst = (isset($data['tekst'])) ? $data['tekst'] : null;
			$this->slika = (isset($data['slika'])) ? $data['slika'] : null;
			$this->flag = (isset($data['flag'])) ? $data['flag'] : null; 
		
		}
		public function getArrayCopy()
		{
			return get_object_vars($this);
		}
	
}
