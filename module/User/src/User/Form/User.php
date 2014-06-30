<?php

/**
 * Description of User
 *
 * @author jacoe
 */
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class User extends Form {
    protected $inputFilter;
    
    public function __construct() {
        parent::__construct();
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'email',
                'required' => true,
                'placeholder' => 'Email Address',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Password',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Password'
            ),
        ));
        
        $this->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder' => 'Verify Password',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Verify Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Type Name',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone Number',
            ),
            'attributes' => array(
                'type' => 'tel',
                'required' => 'required',
                'pattern' => '^[\d/]+$',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'photo',
            'options' => array(
                'label' => 'Your Photo',
            ),
            'attributes' => array(
                'required' => 'required',
                'id' => 'photo',
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
           $factory = new InputFactory();
           
           $inputFilter->add($factory->createInput(array(
               'name' => 'email',
               'filters' => array(
                   array(
                       'name' => 'StripTags'
                   ),
                   array(
                       'name' => 'StringTrim'
                   ),
               ),
               'validators' => array(
                   array(
                       'name' => 'EmailAddress',
                       'options' => array(
                           'messages' => array(
                               'emailAddressInvalidFormat' => 'Email address format is not valid',
                           ),
                       ),
                   ),
                   array(
                       'name' => 'NotEmpty',
                       'options' => array(
                           'messages' => array(
                               'isEmpty' => 'Email address is required',
                           ),
                       ),
                   ),
               ),
           )));
           
           $inputFilter->add($factory->createInput(array(
               'name' => 'password_verify',
               'filters' => array(
                   array(
                       'name' => 'StripTags'
                   ),
                   array(
                       'name' => 'StringTrim'
                   ),
               ),
               'validators' => array(
                   array(
                       'name' => 'identical',
                       'options' => array(
                           'token' => 'password'
                       ),
                   ),                  
               ),
           )));
           
           $inputFilter->add($factory->createInput(array(
               'name' => 'photo',
               'validators' => array(
                   array(
                       'name' => 'filesize',
                       'options' => array(
                           'max' => 2097152,
                       ),                       
                   ),                   
               ),
           )));
           
           $inputFilter->add($factory->createInput(array(
               'name' => 'phone',
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
           )));
           
           $this->inputFilter = $inputFilter;
        }        
        return $this->inputFilter;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("SetInputFilter is not being used");
    }
}

?>
