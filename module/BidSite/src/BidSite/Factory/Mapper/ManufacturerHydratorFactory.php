<?php

/**
 * Description of ManufacturerHydratorFactory
 *
 * @author jacoe
 */
namespace BidSite\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BidSite\Mapper\ManufacturerHydrator;

class ManufacturerHydratorFactory implements FactoryInterface {
    
    /**
     * Return a Manufacturer Hydrator intance
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \BidSite\Mapper\ManufacturerHydrator
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new ManufacturerHydrator();
    }
}

?>