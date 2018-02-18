<?php
namespace Application\Form;
use Zend\Form\Form;

class SelectForm extends Form
{
    public function __construct()
    {
        parent::__construct('select');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'kategorije',
            'type'  => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type'  => 'select',
            ),
            'options'=>array(
                'attributes' => array(
                    'value'=>array(),
                ),
     
            )  
        ));
        
    }
}
