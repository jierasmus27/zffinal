<?php

/**
 * Manufacturer entity class
 *
 * @author jacoe
 */
namespace BidSite\Entity;

class Manufacturer implements ManufacturerInterface {
    
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    public function __contstruct() {
        return $this;
    }
    
    /**
     * Return Item Id
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Return Item name
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Set Item id
     * @param int $id
     * @return \BidSite\Entity\Manufacturer
     */
    public function setId($id) {
        $id = (int) $id;
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set Item name
     * @param string $name
     * @return \BidSite\Entity\Manufacturer
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Magic method for mutators
     * @param string $name
     * @param var $value
     * @return \BidSite\Entity\Manufacturer
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