<?php
namespace Application\Form;
use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{
      public function __construct()
      {
      	$this->add(array(
      			'name' => 'korime',
      			'required' => true,
      			'filters' => array(
      					array(
      							'name' => 'StripTags', //kad naidje na tag brise sve nadalje
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
      			'name' => 'sifra',
      			'required' => true,
      			'filters' => array(
      					array(
      							'name' => 'StripTags', //kad naidje na tag brise sve nadalje
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
      			'name' => 'ime',
      			'required' => true,
      			'filters' => array(
      					array(
      							'name' => 'StripTags', //kad naidje na tag brise sve nadalje
      					),
      			),
      			'validators' => array(
      					array(
      							'name' => 'StringLength',
      							'options' => array(
      									'encoding' => 'UTF-8',
      									'min' => 2,
      									'max' => 30,
      							),
      					),
      			),
      	));
      	
      	$this->add(array(
      			'name' => 'prezime',
      			'required' => true,
      			'filters' => array(
      					array(
      							'name' => 'StripTags', //kad naidje na tag brise sve nadalje
      					),
      			),
      			'validators' => array(
      					array(
      							'name' => 'StringLength',
      							'options' => array(
      									'encoding' => 'UTF-8',
      									'min' => 2,
      									'max' => 50,
      							),
      					),
      			),
      	));
      	
      	$this->add(array(
          		'name' => 'email',
          		'required' => true,
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
          		            'max' => 50,
          		        ),
          		    ),
          		),
          ));
      	
                
      }
}