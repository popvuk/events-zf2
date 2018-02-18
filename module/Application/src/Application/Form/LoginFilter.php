<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'korime',
            'required'   => true,
        ));
        $this->add(array(
            'name'       => 'sifra',
            'required'   => true,
        ));
    }
}
