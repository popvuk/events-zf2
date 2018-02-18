<?php
namespace Application\Form;
use Zend\Form\Form;

class KontaktForm extends Form
{
    public function __construct()
    {
        parent::__construct('Kontakt');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'=>'ime',
            'attributes'=>array(
                'type'=>'text',
                'required'=>'required',
                'placeholder' => 'Unesi ime'
            ),
            'options'=>array(
                'label'=>'Ime:',
            )
        
        ));
        
        $this->add(array(
            'name'=>'email',
            'attributes'=>array(
                'type'=>'email',
                'required'=>'required',
                'placeholder' => 'Unesi e-mail'
            ),
            'options'=>array(
                'label'=>'Email:',
            )
            
        ));
        
        $this->add(array(
            'name'=>'poruka',
            'attributes'=>array(
                'type'=>'textarea',
                'required'=>'required',
                'placeholder' => 'Tekst poruke...'
            ),
            'options'=>array(
                'label'=>'Poruka:',
            )
        
        ));
        
        $this->add(array(
            'name'=>'submit',
            'attributes'=>array(
                'type'=>'submit',
                'value'=>'Pošalji',
            )
        ));
    }
    
} 