<?php
namespace Application\Form;
use Zend\Form\Form;

class KomentarForm extends Form
{
    public function __construct()
    {
        parent::__construct('Komentar');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'=>'komentar',
            'attributes'=>array(
                'type'=>'textarea',
                'required'=>'required',
            ),
            'options'=>array(
                'label'=>'Komentar:',
            )
            
        ));
        
        $this->add(array(
            'name'=>'submit',
            'attributes'=>array(
                'type'=>'submit',
                'value'=>'Dodaj',
            )
        ));
    }
    
} 