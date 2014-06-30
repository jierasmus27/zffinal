<?php

/**
 * Module Options for the BidSite module
 *
 * @author jacoe
 */
namespace BidSite\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ServiceOptionsInterface {

    /**
     * @var string
     */
    protected $logoutRedirectRoute = 'bidsite/login';
    
    /**
     * Array containing all db table mappings
     * @var array
     */
    protected $arrConfig = array('item' => array(
                                     'entityClass' => 'BidSite\Entity\Item',
                                     'tableName' => 'item',
                                     'database' => 'zffinal'),
                                 'manufacturer' => array(
                                     'entityClass' => 'BidSite\Entity\Manufacturer',
                                     'tableName' => 'manufacturer',
                                     'database' => 'zffinal')
                                );
    
    /**
     * Set login redirect route
     * @param string $loginRedirectRoute
     * @return \BidSite\Options\ModuleOptions
     */
    public function setLoginRedirectRoute($loginRedirectRoute) {
        $this->loginRedirectRoute = $loginRedirectRoute;
        return $this;
    }

    /**
     * Return login redirect route
     * @return string
     */
    public function getLoginRedirectRoute() {
        return $this->loginRedirectRoute;
    }
    
    /**
     * Set Table Name for the entity
     * @param string $entity
     * @param string $tableName
     * @throws \Exception
     */
    public function setTableName($entity, $tableName) {
        if (array_key_exists($entity,$this->arrConfig)) {
            $this->arrConfig[$entity]["tableName"] = $tableName;
        } else {
            throw new \Exception("Table Name set method does not exist");
        }
    }
    
    /**
     * Return Table Name for entity 
     * @param string $entity
     * @return string
     * @throws \Exception
     */
    public function getTableName($entity) {
        if (array_key_exists($entity, $this->arrConfig) && (array_key_exists("tableName", $this->arrConfig[$entity]))) {
            return $this->arrConfig[$entity]["tableName"];
        } else {
            throw new \Exception("Table Name set method does not exist");
        }
    }
    
    /**
     * Set entity class name
     * @param string $entity
     * @param string $entityClass
     * @throws \Exception
     */
    public function setEntityClass($entity, $entityClass) {
        if (array_key_exists($entity, $this->arrConfig)) {
            $this->arrConfig[$entity]["entityClass"] = $entityClass;
        } else {
            throw new \Exception("Entity class set method does not exist");
        }
    }
    
    /**
     * Return entity class name
     * @param string $entity
     * @return string
     * @throws \Exception
     */
    public function getEntityClass($entity) {
        if (array_key_exists($entity, $this->arrConfig) && (array_key_exists("entityClass", $this->arrConfig[$entity]))) {
            return $this->arrConfig[$entity]["entityClass"];
        } else {
            throw new \Exception("Entity Class set method does not exist");
        }
    }
}

?>