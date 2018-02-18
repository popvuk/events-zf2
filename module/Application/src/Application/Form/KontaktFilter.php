<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class KontaktFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'=>'ime',
            'required'=>true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 100,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name'=>'email',
            'required'=>true,
            'filters' => array(
      					array(
      							'name' => 'StripTags', 
      					),
      			),
      			'validators' => array(
				        array(
          						'name' => 'EmailAddress',
          						'options' => array(
          								'domain' => true,
          						),
          				),
      					array(
      							'name' => 'StringLength',
      							'options' => array(
      									'encoding' => 'UTF-8',
      									'min' => 2,
      									'max' => 150,
      							),
      					),
      			),
        ));
        
        $this->add(array(
            'name'=>'poruka',
            'required'=>true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 1500,
                    ),
                ),
            ),
        ));
    }
}