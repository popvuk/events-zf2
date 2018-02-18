<?php
namespace Application\Form;

use Zend\Form\Form;

class PostForm extends Form
{

	public function __construct()
	{
		parent::__construct('Post');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		
		$this->add(array(
		    'name' => 'naslov',
		    'attributes' => array(
		        'type'  => 'text',
		        'required' => 'required' ,
		        'placeholder' => 'Naslov posta'
		    ),
		    'options' => array(
		        'label' => 'Naslov:',
		    ),
		));
		
		$this->add(array(
		    'name' => 'id_kat',
		    'type'  => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'type'  => 'select',
		    ),
		    'options' => array(
		        'label' => 'Kategorija:',
		        'disable_inarray_validator' => true,
		    ),
		    
		));
		
		$this->add(array(
        		'name' => 'dat_od',
        		'attributes' => array(
        				'type'  => 'Zend\Form\Element\Date',
        				'required'=>'required',
        		        'placeholder' => 'dd.mm.gggg'
        		),
        		'options' => array(
        				'label' => 'Datum početka: ',
        		),
        ));
		
		$this->add(array(
        		'name' => 'dat_do',
        		'attributes' => array(
        				'type'  => 'Zend\Form\Element\Date',
        		        'placeholder' => 'dd.mm.gggg'
        		),
        		'options' => array(
        				'label' => 'Datum završetka: ',
        		),
        ));
		
		$this->add(array(
		    'name' => 'vreme',
		    'attributes' => array(
		        'type'  => 'Zend\Form\Element\Date',
		        'placeholder' => 'hh:mm',
		    ),
		    'options' => array(
		        'label' => 'Vreme početka: ',
		    ),
		));
		
		$this->add(array(
            'name' => 'lokacija',
            'attributes' => array(
                'type'  => 'text',
				'required' => 'required' ,
                'placeholder' => 'Adresa lokacije'
            ),
            'options' => array(
                'label' => 'Lokacija:',
            ),
        ));
		
		 $this->add(array(
            'name' => 'tekst',
            'attributes' => array(
                'type'  => 'textarea',
				'required' => 'required' ,
                'placeholder' => 'Tekst posta'
            ),
            'options' => array(
                'label' => 'Tekst:',
            ),
        ));

		 $this->add(array(
		     'name' => 'slika',
		     'attributes' => array(
		         'type'  => 'file',	
		     ),
		     'options' => array(
		         'label' =>'Slika:',
		     ),
		 ));
		 
		$this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Dodaj',
            ),
        ));
		
	}
	

}