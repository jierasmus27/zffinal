<?php

/**
 * Description of ItemForm
 *
 * @author jacoe
 */
namespace BidSite\Form;

use Zend\Form\Form;
use Zend\Form\Element;
Use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class ItemForm extends Form {
    protected $inputFilter;
    
    public function __construct() {
        parent::__construct('item');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'product name',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Item Product Name'
            ),
        ));
        
        $this->add(array(
            'name' => 'model',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'model number',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Item Model Number'
            ),
        ));
        
        $this->add(array(
            'name' => 'manufacturer_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Manufacturer id',
            ),
            'attributes' => array(
                'required' => 'required',
                'pattern' => '^[\d/]+$',
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'describe the item',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Description of the item'
            ),
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'submit',
                'required' => 'false',
            ),
        ));
    }
    
    public function getInputFilter() {
        if (!$this->inputFilter) {
           $inputFilter = new InputFilter();
           
           $inputFilter->add(array(
               'name'       => 'id',
               'required'   => false,
               'filters' => array(
                   array('name' => 'digits'),
                   array('name' => 'stringtrim'),
               ),
               'validators' => array(
                   array(
                       'name' => 'regex',
                       'options' => array(
                           'pattern' => '/^[\d-\/]+$/',
                       ),
                   ),
               ),
           ));
           
           $inputFilter->add(array(
               'name'       => 'name',
               'required'   => true,
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'min' => 2,
                       ),
                   ),
               ),
               'filters'   => array(
                   array('name' => 'StringTrim'),
               ),
           ));
           
           $inputFilter->add(array(
               'name'       => 'model',
               'required'   => true,
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'min' => 2,
                       ),
                   ),
               ),
               'filters'   => array(
                   array('name' => 'StringTrim'),
               ),
           ));
                   
           $inputFilter->add(array(
               'name' => 'manufacturer_id',
               'filters' => array(
                   array('name' => 'digits'),
                   array('name' => 'stringtrim'),
               ),
               'validators' => array(
                   array(
                       'name' => 'regex',
                       'options' => array(
                           'pattern' => '/^[\d-\/]+$/',
                       ),
                   ),
               ),
           ));
           
           $inputFilter->add(array(
               'name'       => 'description',
               'required'   => true,
               'validators' => array(
                   array(
                       'name'    => 'StringLength',
                       'options' => array(
                           'min' => 5,
                       ),
                   ),
               ),
               'filters'   => array(
                   array('name' => 'StringTrim'),
               ),
           ));
           
           $this->inputFilter = $inputFilter;
        }        
        return $this->inputFilter;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("SetInputFilter is not being used");
    }    
}

?>