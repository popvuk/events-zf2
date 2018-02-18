<?php
namespace Application\Form;
use Zend\InputFilter\InputFilter;

class PostFilter extends InputFilter
{
      public function __construct()
      {

          $this->add(array(
              'name' => 'naslov',
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
                          'max' => 250,
                      ),
                  ),
              ),
          ));
          
          $this->add(array(
              'name' => 'id_kat',
          ));
          
      	$this->add(array(
				'name' => 'dat_od',
				'required' => true,
				'filters' => array(
						array(
								'name' => 'StripTags',
						),
				),
				'validators' => array(
						array(
								'name' => 'Date',
								'options' => array(
										'format' => 'd.m.Y',
								),
						),
				),
		));
      	
      	$this->add(array(
				'name' => 'dat_do',
				'required' => false,
				'filters' => array(
						array(
								'name' => 'StripTags', 
						),
				),
				'validators' => array(
						array(
								'name' => 'Date',
								'options' => array(
										'format' => 'd.m.Y',
								),
						),
				),
		));
      	
      	$this->add(array(
      	    'name' => 'vreme',
      	    'required' => false,
      	    'filters' => array(
      	        array(
      	            'name' => 'StripTags',
      	        ),
      	    ),
      	    'validators' => array(
						array(
								'name' => 'Date',
								'options' => array(
										'format' => 'H:i',
										'messages'=>array(
												'dateInvalidDate'=>'Upis mora biti u obliku sat:min'
										)
								),
						),
				),
      	));
      	
      	$this->add(array(
      			'name' => 'lokacija',
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
      									'max' => 200,
      							),
      					),
      			),
      	));
      	
      	$this->add(array(
      	    'name'       => 'slika',
      	    'required'   => true,      	    	
      	    'validators' => array(
      	        array(
      	            'name' => 'fileextension',
      	            'options' => array(
      	                'extension' => array('png', 'jpeg', 'jpg', 'bmp'),
      	                'break_chain_on_failure' => true,
      	            ),
      	
      	        ),
      	        array(
      	            'name' => 'filesize',
      	            'options' => array(
      	                'min' => '0.005MB',
      	                'max' => '5MB',
      	            ),
      	        ),
      	    ),
      	));
      	
      	$this->add(array(
      			'name' => 'tekst',
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
      									'max' => 5000,
      							),
      					),
      			),
      	));
      	
                
      }
}