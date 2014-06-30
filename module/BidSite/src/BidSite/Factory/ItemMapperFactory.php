<?php

/**
 * Description of ItemMapperFactory
 *
 * @author jacoe
 */
namespace BidSite\Factory;

use Zend\Db;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use BidSite\Mapper\ItemMapper;
use BidSite\Options;

class ItemMapperFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $options = $serviceLocator->get('bidsite_module_options');
        $dbAdapter = $serviceLocator->get('bidsite_zend_db_adapter');
        
        $mapper = new ItemMapper();
        $mapper->setDbAdapter($dbAdapter);
        
        $entityClass = $options->getEntityClass("item");

        $hydrator = $serviceLocator->get('bidsite_item_hydrator');
        
        $mapper->setEntityPrototype(new $entityClass())
               ->setHydrator($hydrator)
               ->setTableName($options->getTableName("item"));
        return $mapper;
    }
    
}

?>