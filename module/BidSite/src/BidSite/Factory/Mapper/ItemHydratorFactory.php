<?php

/**
 * Description of ItemHydratorFactory
 *
 * @author jacoe
 */
namespace BidSite\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BidSite\Mapper\ItemHydrator;

class ItemHydratorFactory implements FactoryInterface {
    
    /**
     * Return an ItemHydrator instance
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \BidSite\Mapper\ItemHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new ItemHydrator();
    }
}

?>