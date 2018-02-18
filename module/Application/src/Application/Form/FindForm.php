<?php

namespace Application\Form;

use Zend\Form\Form;

class FindForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Find');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        
        $this->add(array(
            'name' => 'korime',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Unesi korisničko ime'
            ),
            'options' => array(
                'label' => 'Korisničko ime:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Nadji',
            ),
        )); 
        
    
    }
}
