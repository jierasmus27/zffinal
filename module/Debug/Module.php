<?php
namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface {
    public function init(ModuleManager $moduleManager) {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach('loadModules.post', array($this, 'loadedModulesInfo'));
    }
    
    public function loadedModulesInfo(Event $event) {
        $moduleManager = $event->getTarget();
        $loadedModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadedModules, true));
    }
    
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        
        $serviceManager = $e->getApplication()->getServiceManager();
        $timer = $serviceManager->get('timer');
        $timer->start('mvc-execution');
        
        $eventManager->attach(MvcEvent::EVENT_FINISH, array($this, 'getMvcDuration'),2);
    }
    
    public function getMvcDuration(MvcEvent $e) {
        $serviceManager = $e->getApplication()->getServiceManager();
        
        $timer = $serviceManager->get('timer');
        $duration = $timer->stop('mvc-execution');
        error_log("Mvc Duration: ". $duration. " seconds");
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
            'factories' => array(
                
            )
        );
    }
}
?>