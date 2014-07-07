<?php

/**
 * User entity class
 *
 * @author jacoe
 */
namespace BidSite\Entity;

class User implements UserInterface {
    
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $first_name;
    
    /**
     * @var string
     */
    protected $last_name;
    
    /**
     * @var string 
     */
    protected $password;
    
    /**
     * @var string 
     */
    protected $salt;
    
    /**
     * @var string
     */
    protected $status;
    
    /**
     * @var string 
     */
    protected $role;
    
    
    /**
     * Return User Id
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Return User first name
     * @return string
     */
    public function getFirstName() {
        return $this->first_name;
    }
    
    /**
     * Return User last name
     * @return string
     */
    public function getLastName() {
        return $this->last_name;
    }    
    
    /**
     * Return User email
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Return User password
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * Return User salt
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }
    
    /**
     * Return User Status
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * Return User Role
     * @return string
     */
    public function getRole() {
        return $this->role;
    }    
    
    /**
     * Set User id
     * @param int $id
     * @return \BidSite\Entity\User
     */
    public function setId($id) {
        $id = (int) $id;
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set User first name
     * @param string $first_name
     * @return \BidSite\Entity\User
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
        return $this;
    }
    
    /**
     * Set User last name
     * @param string $last_name
     * @return \BidSite\Entity\User
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
        return $this;
    }
    
    /**
     * Set User email
     * @param string $email
     * @return \BidSite\Entity\User
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    /**
     * Set User Password
     * @param string $password
     * @return \BidSite\Entity\User
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    
    /**
     * Set User salt
     * @param string $salt
     * @return \BidSite\Entity\User
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }
    
    /**
     * Set User status
     * @param string $status
     * @return \BidSite\Entity\User
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Set User role
     * @param string $role
     * @return \BidSite\Entity\User
     */
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }
        
    /**
     * Magic method for mutators
     * @param string $name
     * @param type $value
     * @return this
     */
    public function __set($name, $value) {
        $method = "set". $this->variableToMethodString($name);
        
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
    }
    
    /**
     * Return property values
     * @param string $name
     * @return var
     */
    public function __get($name) {
        $method = "get". $this->variableToMethodString($name);
        
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }
    
    /**
     * Return array of object properties
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    /**
     * Convert underscored properties (i.e manufacturer_id to ManufacturerId)
     * @param string $variable_name
     * @return string
     */
    protected function variableToMethodString($variable_name) {
        $var_split = preg_split("/_/", $variable_name);
        $return_string = "";
        foreach ($var_split as $var) {
            $return_string .= ucFirst($var);
        }
        return $return_string;
    }
}

?>