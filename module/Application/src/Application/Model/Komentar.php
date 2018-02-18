<?php
namespace Application\Model;

class Komentar 
{
    public $id_kom;
    public $id_post;
    public $korime;
    public $komentar;
    public $vreme;
    
    public function exchangeArray($data)
    {
        $this->id_kom = (isset($data['id_kom'])) ? $data['id_kom'] : null;
        $this->id_post = (isset($data['id_post'])) ? $data['id_post'] : null;
        $this->korime = (isset($data['korime'])) ? $data['korime'] : null;
        $this->komentar = (isset($data['komentar'])) ? $data['komentar'] : null;
        $this->vreme = (isset($data['vreme'])) ? $data['vreme'] :null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
