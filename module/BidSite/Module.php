<?php
namespace BidSite;

use BidSite\Model\User;
use BidSite\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;

class Module {
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'bidsite_item_service' => 'BidSite\Service\ItemService',
                'bidsite_item_form'    => 'BidSite\Form\ItemForm',
            ),
            'factories' => array(
                'bidsite_module_options' => 'BidSite\Factory\ModuleOptionsFactory',
                'bidsite_item_mapper'   => 'BidSite\Factory\ItemMapperFactory',
                'bidsite_item_hydrator' => 'BidSite\Factory\Mapper\ItemHydratorFactory',
                'bidsite_manufacturer_mapper'   => 'BidSite\Factory\ManufacturerMapperFactory',
                'bidsite_manufacturer_hydrator' => 'BidSite\Factory\Mapper\ManufacturerHydratorFactory',
            )
        );
    }
    
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
    }
    
    public function handleError(MvcEvent $e) {
        $controller = $e->getController();
        $error = $e->getParam('error');
        $exception = $e->getParam('exception');
        $message = "Error: ". $error;
        
        if ($exception instanceOf \Exception) {
            $message .= ", Exception: (". $exception->getMessage(). "): ".
                        $exception->getTraceAsString();
        }        
        error_log($message);
    }
}
?>