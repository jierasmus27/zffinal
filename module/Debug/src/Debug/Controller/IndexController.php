<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        return array(
            'application_name' => $config['application']['name'],
            'version' => $config['application']['version'],
        );
    }
    
    public function aboutAction() {
        return array();
    }
}

?>
