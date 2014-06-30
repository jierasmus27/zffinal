<?php

/**
 * ItemController class
 *
 * @author jacoe
 */
namespace BidSite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use BidSite\Form\ItemForm;
use BidSite\Service\ItemService;

class ItemController extends AbstractActionController {
    
    /**
     * @var \BidSite\Service\ItemService
     */
    protected $itemService;
    
    /**
     * @var \BidSite\Form\ItemForm 
     */
    protected $itemForm;
    
    /**
     * View an Item
     * 
     * @return array Id and Item view form
     */
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
    
    /**
     * Edit an Item
     * 
     * @return array Id and Item view form
     */
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
    
    /**
     * Add an Item
     * 
     * @return array Item add form
     */
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
    
    /**
     * Return index of all items
     * 
     * @return array
     */
    public function indexAction() {
        $service = $this->getItemService();

        $items = $service->findAll();
    
        return array(
            'items' => $items,
        );
    }
    
    /**
     * Return the relevant Item Form
     * 
     * @return \Bidite\Form\ItemForm
     */
    public function getItemForm() {
        if (!$this->itemForm) {
            $this->setItemForm($this->getServiceLocator()->get('bidsite_item_form'));
        }
        return $this->itemForm;
    }
    
    /**
     * Set the relevant Item Form
     * 
     * @param \Bidite\Form\ItemForm
     * @return ItemController
     */
    public function setItemForm(ItemForm $itemForm) {
        $this->itemForm = $itemForm;
        $fm = $this->flashMessenger()->setNamespace('bidsite-item-form')->getMessages();
        if (isset($fm[0])) {
            $this->itemForm->setMessages(array('identity' => array($fm[0])));
        }
        return $this;
    }
    
    /**
     * Return the Item Service object
     * 
     * @return \BidSite\Service\ItemService
     */
    public function getItemService() {
        if (!$this->itemService) {
            $this->itemService = $this->getServiceLocator()->get('bidsite_item_service');
        }
        return $this->itemService;
    }

    /**
     * Set the Item Service object
     * 
     * @param \BidSite\Service\ItemService
     * @return ItemController
     */
    public function setItemService(ItemService $itemService)
    {
        $this->itemService = $itemService;
        return $this;
    }
}

?>