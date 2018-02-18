<?php
namespace Application\Model;

class Tip {

    public $id_tipa;
    public $tip_fajla;

    function exchangeArray($data)
    {
        $this->id_tipa = (isset($data['id_tipa'])) ? $data['id_tipa'] : null;
        $this->tip_fajla = (isset($data['tip_fajla'])) ? $data['tip_fajla'] : null; 
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}