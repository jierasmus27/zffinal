<?php

/**
 * Description of ModuleOptions
 *
 * @author jacoe
 */
namespace BidSite\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ServiceOptionsInterface {

    protected $logoutRedirectRoute = 'bidsite/login';
    protected $arrConfig = array('item' => array(
                                     'entityClass' => 'BidSite\Entity\Item',
                                     'tableName' => 'item',
                                     'database' => 'zffinal'),
                                 'manufacturer' => array(
                                     'entityClass' => 'BidSite\Entity\Manufacturer',
                                     'tableName' => 'manufacturer',
                                     'database' => 'zffinal')
                                );
    
    public function setLoginRedirectRoute($loginRedirectRoute) {
        $this->loginRedirectRoute = $loginRedirectRoute;
        return $this;
    }

    public function getLoginRedirectRoute() {
        return $this->loginRedirectRoute;
    }
    
    public function setTableName($entity, $tableName) {
        if (array_key_exists($entity,$this->arrConfig)) {
            $this->arrConfig[$entity]["tableName"] = $tableName;
        } else {
            throw new \Exception("Table Name set method does not exist");
        }
    }
    
    public function getTableName($entity) {
        if (array_key_exists($entity, $this->arrConfig) && (array_key_exists("tableName", $this->arrConfig[$entity]))) {
            return $this->arrConfig[$entity]["tableName"];
        } else {
            throw new \Exception("Table Name set method does not exist");
        }
    }
    
    public function setEntityClass($entity, $entityClass) {
        if (array_key_exists($entity, $this->arrConfig)) {
            $this->arrConfig[$entity]["entityClass"] = $entityClass;
        } else {
            throw new \Exception("Entity class set method does not exist");
        }
    }
    
    public function getEntityClass($entity) {
        if (array_key_exists($entity, $this->arrConfig) && (array_key_exists("entityClass", $this->arrConfig[$entity]))) {
            return $this->arrConfig[$entity]["entityClass"];
        } else {
            throw new \Exception("Entity Class set method does not exist");
        }
    }
}

?>