<?php

/**
 * ModuleOptionsFactory class
 *
 * @author jacoe
 */
namespace BidSite\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BidSite\Options\ModuleOptions;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Return the ModuleOptions for the site
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \BidSite\Options\ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        return new ModuleOptions(isset($config['bidsite']) ? $config['bidsite'] : array());
    }
}

?>