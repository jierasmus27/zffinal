<?php

/**
 * Description of ItemController
 *
 * @author jacoe
 */
namespace BidSite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use BidSite\Form\ItemForm;
use BidSite\Service\ItemService;

class ItemController extends AbstractActionController {
    protected $itemService;
    protected $itemForm;
    
    public function viewAction() {        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('item', array('action' => 'index'));
        }
        
        $request = $this->getRequest();
        $service = $this->getItemService();
        $form = $this->getItemForm();
        $post = $request->getPost();

        $fm = $this->flashMessenger()->setNamespace('edit-item')->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        
        if ($request->isPost()) {
            $form->setData($post);

            if ($form->isValid()) {
                $this->itemService->update($form->getData());
                return $this->redirect()->toRoute('item', array('action' => 'edit'));
            }
        }
        
        $item = $service->findById($id);
        $form->bind($item);
        
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    public function editAction() {        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('item', array('action' => 'index'));
        }
        
        $request = $this->getRequest();
        $service = $this->getItemService();
        $form = $this->getItemForm();
        $post = $request->getPost();
        
        $item = $service->findById($id);
        print_r($item);
        $manufacturers = $service->loadAllManufacturers();
        
        $arr_manufacturers = array();
        foreach ($manufacturers as $manufacturer) {
            $arr_manufacturers[$manufacturer->id] = $manufacturer->name;
        }
        
        $form->get('manufacturer_id')->setValueOptions($arr_manufacturers);

        $fm = $this->flashMessenger()->setNamespace('edit-item')->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        
        if ($request->isPost()) {
            $form->setData($post);

            if ($form->isValid()) {
                $this->itemService->update($form->getData());
                return $this->redirect()->toRoute('item', array('action' => 'edit', 'id' => $id));
            }
        }
        
        $form->bind($item);
        
        return array(
            'id' => $id,
            'form' => $form,
        );       
    }
    
    public function addAction() {        
        $request = $this->getRequest();
        $service = $this->getItemService();
        $form = $this->getItemForm();
        $post = $request->getPost();
        
        $fm = $this->flashMessenger()->setNamespace('add-item')->getMessages();
        if (isset($fm[0])) {
            $status = $fm[0];
        } else {
            $status = null;
        }
        
        $manufacturers = $service->loadAllManufacturers();
       
        $arr_manufacturers = array();
        foreach ($manufacturers as $manufacturer) {
            $arr_manufacturers[$manufacturer->id] = $manufacturer->name;
        }
        
        $form->get('manufacturer_id')->setValueOptions($arr_manufacturers);
        
        if ($request->isPost()) {
            $form->setData($post);

            if ($form->isValid()) {
                $item = $this->itemService->add($form->getData());
                return $this->redirect()->toRoute('item', array('action' => 'edit', 'id' => $item->id));
            }
        }
        
        return array(
            'form' => $form,
        );       
    }
    
    public function indexAction() {
        $service = $this->getItemService();

        $items = $service->findAll();
    
        return array(
            'items' => $items,
        );
    }
    
    public function getItemForm() {
        if (!$this->itemForm) {
            $this->setItemForm($this->getServiceLocator()->get('bidsite_item_form'));
        }
        return $this->itemForm;
    }
    
    public function setItemForm(ItemForm $itemForm) {
        $this->itemForm = $itemForm;
        $fm = $this->flashMessenger()->setNamespace('bidsite-item-form')->getMessages();
        if (isset($fm[0])) {
            $this->itemForm->setMessages(array('identity' => array($fm[0])));
        }
        return $this;
    }
    
    public function getItemService() {
        if (!$this->itemService) {
            $this->itemService = $this->getServiceLocator()->get('bidsite_item_service');
        }
        return $this->itemService;
    }

    public function setItemService(ItemService $itemService)
    {
        $this->itemService = $itemService;
        return $this;
    }
}

?>