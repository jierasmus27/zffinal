<?php

/**
 * Description of AccountController
 *
 * @author jacoe
*/
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\User as UserForm;

class AccountController extends AbstractActionController {
    public function indexAction() {
        return array();
    }
    public function addAction() {
        $form = new UserForm();
        
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive($this->getRequest()->getPost()->toArray(),
                                          $this->getRequest()->getFiles()->toArray());
            $form->setData($data);
            if ($form->isValid()) {
                // @TODO: save user data
            }
        }
        return array('form' => $form);
    }
    public function registerAction() {
        return array();
    }
    public function viewAction() {
        return array();
    }
    public function editAction() {
        return array();
    }
    public function deleteAction() {
        return array();
    }
}

?>
