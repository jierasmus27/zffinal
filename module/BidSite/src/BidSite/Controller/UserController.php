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
    
    /**
     * @var \BidSite\Service\UserService
     */
    protected $userService;
    
    /**
     * @var \BidSite\Form\UserForm 
     */
    protected $userForm;
    
    /**
     * Index action for User Controller
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        return array('users' => $this->userService()->findAll());
    }
    
    /**
     * Add action for User Controller
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() {
        return new ViewModel();
    }
    
    /**
     * Edit action for User Controller
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction() {
        return new ViewModel();
    }
    
    /**
     * Delete action for User Controller
     * @return \Zend\View\Model\ViewModel
     */
    public function deleteAction() {
        return new ViewModel();
    }
    
    /**
     * View action for User Controller
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {
        return new ViewModel();
    }
    
    
    /**
     * Return the relevant User Form
     * 
     * @return \Bidite\Form\UserForm
     */
    public function getUserForm() {
        if (!$this->userForm) {
            $this->setUserForm($this->getServiceLocator()->get('bidsite_user_form'));
        }
        return $this->userForm;
    }
    
    /**
     * Set the relevant User Form
     * 
     * @param \Bidite\Form\UserForm
     * @return UserController
     */
    public function setUserForm(UserForm $userForm) {
        $this->userForm = $userForm;
        $fm = $this->flashMessenger()->setNamespace('bidsite-user-form')->getMessages();
        if (isset($fm[0])) {
            $this->userForm->setMessages(array('identity' => array($fm[0])));
        }
        return $this;
    }
    
    /**
     * Return the User Service object
     * 
     * @return \BidSite\Service\UserService
     */
    public function getUserService() {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('bidsite_user_service');
        }
        return $this->userService;
    }

    /**
     * Set the User Service object
     * 
     * @param \BidSite\Service\UserService
     * @return UserController
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }
}

?>