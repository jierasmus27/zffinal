<?php

/**
 * Description of TimerAbstractFactory
 *
 * @author jacoe
 */
namespace Debug\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Debug\Service\Timer as TimerService;

class TimerAbstractFactory implements AbstractFactoryInterface {
    /**
     * Configuration file array key
     * @var string
     */
    protected $configKey = "timers";
    
    /**
     * Check if can create a service
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        $config = $serviceLocator->get('config');
        if (empty($config)) {
            return false;
        }
        
        return isset($config[$this->configKey][$requestedName]);
    }
    
    /**
     * Create the requested service
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return \Debug\Service\Timer
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        $config = $serviceLocator->get('config');
        $timer = new TimerService($config[$this->configKey][$requestedName]['times_as_float']);
        return $timer;
    }
    
}

?>
