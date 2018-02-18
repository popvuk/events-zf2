<?php
namespace Application\Model;

class Facebook {

    public $id_face;
    public $naziv_grupe;
    public $id_grupe;
    public $id_tip;

    function exchangeArray($data)
    {
        $this->id_face = (isset($data['id_face'])) ? $data['id_face'] : null;
        $this->naziv_grupe = (isset($data['naziv_grupe'])) ? $data['naziv_grupe'] : null; 
        $this->id_grupe = (isset($data['id_grupe'])) ? $data['id_grupe'] : null;
        $this->id_tip = (isset($data['id_tip'])) ? $data['id_tip'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}