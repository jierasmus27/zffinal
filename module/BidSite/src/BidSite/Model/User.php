<?php

/**
 * User Model class
 *
 * @author jierasmus27
 */
namespace BidSite\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface {
    protected $id;
    protected $email;
    protected $first_name;
    protected $last_name;
    protected $password;
    protected $salt;
    protected $status;
    
    protected $inputFilter;
    
    /**
     * Exchange Data array for User properties
     * 
     * @param array $data
     */
    public function exchangeArray($data) {
        (!empty($data['id'])) ? $this->setId($data['id']) : $this->id = null;
        (!empty($data['email'])) ? $this->setEmail($data['email']) : $this->email = null;
        (!empty($data['first_name'])) ? $this->setFirstName($data['first_name']) : $this->first_name = null;
        (!empty($data['last_name'])) ? $this->setLastName($data['last_name']) : $this->last_name = null;
        (!empty($data['password'])) ? $this->setPassword($data['password']) : $this->password = null;
        (!empty($data['salt'])) ? $this->setSalt($data['salt']) : $this->salt = null;
        (!empty($data['status'])) ? $this->setStatus($data['status']) : $this->status = null;
    }
    
    /**
     * Get a copy of the user properties
     * 
     * @return array of properties
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    /**
     * Set the inputfilter to comply with the InputFilterAwareInterface
     * 
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     * @throws \Exception as the method is not used
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not Used");
    }
    
    /**
     * Return the inputFilter for the User class
     * 
     * @return InputFilter inputFilter
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'required' => true,
                'filters' => array(                    
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(                        
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                        'name' => 'EmailAddress',
                    ),
                ),
            )));
            
            $inputFilter->add(array(
                'name' => 'first_name',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 2
                        ),
                    ),
                ),
            ));            
            
            $inputFilter->add(array(
                'name' => 'last_name',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 2
                        ),
                    ),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 8
                        ),
                    ),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'status',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'not_empty',
                    ),
                    array(
                        'name' => 'string_length',
                        'options' => array(
                            'min' => 4
                        ),
                    ),
                ),
            ));           
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    /*
     * Function to set the id property
     * 
     * @param $id is the primary key
     */
    private function setId($id) {        
         $id = (int) $id;
         if ($id < 0) {
             throw new \InvalidArgumentException("Id cannot be negative");
         }         
         $this->id = $id;
    }
    
    /*
     * Function to set the Email property
     * 
     * @param $email is the user email address
     */
    private function setEmail($email) {
         if ($email == "") {
             throw new \InvalidArgumentException("Email address not supplied");
         }
         $this->email = $email;
    }
    
    /*
     * Function to set the First Name property
     * 
     * @param $first_name is the First Name
     */
    private function setFirstName($first_name) {
         if ($first_name == "") {
             throw new \InvalidArgumentException("First Name not supplied");
         }
         $this->first_name = $first_name;
    }
    
    /*
     * Function to set the Last Name property
     * 
     * @param $last_name is the Last Name
     */
    private function setLastName($last_name) {
         if ($last_name == "") {
             throw new \InvalidArgumentException("Last Name not supplied");
         }
         $this->last_name = $last_name;
    }
    
    /*
     * Function to set the Password property
     * 
     * @param $password is the User password
     */
    private function setPassword($password) {
         if (strlen($password) < 8)  {
             throw new \InvalidArgumentException("Invalid Password supplied");
         }
         $this->password = $password; 
    }
    
    /*
     * Function to set the Salt property
     * 
     * @param $salt is the User password salt
     */
    private function setSalt($salt) {
         if ($salt == "")  {
             throw new \InvalidArgumentException("Invalid Password Salt supplied");
         }
         $this->salt = $salt;
    }
    
    /*
     * Function to set the status property
     * 
     * @param $status is the current User status
     */
    private function setStatus($status) {
         if ($status == "")  {
             throw new \InvalidArgumentException("Invalid status supplied");
         }
         $this->status = $status;
    }
    
    /**
     * Magic method to set the object properties
     * 
     * @param string $name is the property name to set
     * @param string $value is the value of the property to set
     */
    public function __set($name, $value) {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Attempted setting invalid user property");
        }
        $method = "set". ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->$name = $value;
        }
    }
    
    /**
     * Magic method to return the value of the requested property
     * 
     * @param string $name is the name of the variable to retrieve
     * @return variable property
     * @throws \InvalidArgumentException if the requested property does not exist
     */
    public function __get($name) {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Attempted getting invalid user property");
        }
        $method = "get". ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {            
            return $this->$name;
        }
    }
    
}

?>