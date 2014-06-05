<?php
/**
 * User Controller
 * 
 * @author jierasmus27
 */
namespace BidSite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController {
    protected $userTable;
    
    /**
     * Index action for User Controller
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        return new ViewModel($this->getUserTable()->fetchAll());
    }
    
    /**
     * Add action for User Controller
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() {
        return new ViewModel();
    }
    
    /**
     * Edit action for User Controller
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction() {
        return new ViewModel();
    }
    
    /**
     * Delete action for User Controller
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function deleteAction() {
        return new ViewModel();
    }
    
    /**
     * View action for User Controller
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {
        return new ViewModel();
    }
    
    
    public function getUserTable() {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('BidSite\Model\UserTable');
        }
        return $this->userTable;
    }
}

?>