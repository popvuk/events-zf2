<?php
namespace Application\Form;
use Zend\InputFilter\InputFilter;

class FindFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
      			'name' => 'korime',
      			'required' => true,
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
    }
}
