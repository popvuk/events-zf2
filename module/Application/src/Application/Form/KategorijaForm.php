<?php

namespace Application\Form;

use Zend\Form\Form;

class KategorijaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Kategorija');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'naziv_kat',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Unesi naziv kategorije'
            ),
            'options' => array(
                'label' => 'Kategorija:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Dodaj',
            ),
        )); 
        
    
    }
}
