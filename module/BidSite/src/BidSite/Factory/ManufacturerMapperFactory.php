<?php

/**
 * Description of ManufacturerMapperFactory
 *
 * @author jacoe
 */
namespace BidSite\Factory;

use Zend\Db;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use BidSite\Mapper\ManufacturerMapper;
use BidSite\Options;

class ManufacturerMapperFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $options = $serviceLocator->get('bidsite_module_options');
        $dbAdapter = $serviceLocator->get('bidsite_zend_db_adapter');
        
        $mapper = new ManufacturerMapper();
        $mapper->setDbAdapter($dbAdapter);
        
        $entityClass = $options->getEntityClass("manufacturer");
        
        $hydrator = $serviceLocator->get('bidsite_manufacturer_hydrator');

        $mapper->setEntityPrototype(new $entityClass())
               ->setHydrator($hydrator)
               ->setTableName($options->getTableName("manufacturer"));
        return $mapper;
    }
    
}

?>