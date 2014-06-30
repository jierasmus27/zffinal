<?php

/**
 * Item entity class
 *
 * @author jacoe
 */
namespace BidSite\Entity;

class Item implements ItemInterface {
    
    /**
     * @var int
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $model;
    
    /**
     * @var int
     */
    protected $manufacturer;
    
    //public $manufacturer_id;
    
    /**
     * @var string 
     */
    protected $description;
    
    public function __construct() {
        $manufacturer = new Manufacturer();
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
     * Return Item model
     * @return string
     */
    public function getModel() {
        return $this->model;
    }
    
    /**
     * Return Item manufacturer
     * @return Manufacturer
     */
    public function getManufacturer() {
        return $this->manufacturer;
    }
    
    /**
     * Return Item description
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Set Item id
     * @param int $id
     * @return \BidSite\Entity\Item
     */
    public function setId($id) {
        $id = (int) $id;
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set Item name
     * @param string $name
     * @return \BidSite\Entity\Item
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set Item model
     * @param string $model
     * @return \BidSite\Entity\Item
     */
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }
    
    /**
     * Set Item manufacturer_id
     * @param int $manufacturer_id
     * @return \BidSite\Entity\Item
     */
    public function setManufacturer($manufacturer) {
        $this->manufacturer = $manufacturer;
        return $this;
    }
    
    /**
     * Set Item description
     * @param string $description
     * @return \BidSite\Entity\Item
     */
    public function setDescription($description) {
        $this->description = $description;
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