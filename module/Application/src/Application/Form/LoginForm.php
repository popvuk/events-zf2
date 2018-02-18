<?php

namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        
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
            'name' => 'sifra',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required' ,
                'placeholder' => 'Unesi šifru'
            ),
            'options' => array(
                'label' => 'Šifra:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                
            ),
        )); 
        
    
    }
}
