<?php
namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{

	public function __construct()
	{
		parent::__construct('Register');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		
		 $this->add(array(
            'name' => 'korime',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Odaberi korisničko ime'
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
                'placeholder' => 'Odaberi šifru'
            ),
            'options' => array(
                'label' => 'Šifra:',
            ),
        ));
		
		$this->add(array(
            'name' => 'ime',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Unesi ime'
            ),
            'options' => array(
                'label' => 'Ime:',
            ),
        ));
		
		$this->add(array(
            'name' => 'prezime',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Unesi prezime'
            ),
            'options' => array(
                'label' => 'Prezime:',
            ),
        ));
		
		 $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'email',
				'required' => 'required' ,
                'placeholder' => 'Unesi e-mail'
            ),
            'options' => array(
                'label' => 'Email:',
            ),
        )); 
		 
		$this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Registruj se',
            ),
        ));
		
	}
	

}