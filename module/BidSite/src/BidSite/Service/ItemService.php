<?php

/**
 * Description of ItemService
 *
 * @author jacoe
 */
namespace BidSite\Service;

use Zend\Form\FormInterface as Form;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;
use BidSite\Mapper\HydratorInterface;
use BidSite\Mapper\ItemMapperInterface;
use BidSite\Options\ServiceOptionsInterface as ServiceOptions;
use BidSite\Mapper\ManufacturerMapperInterface;

class ItemService extends EventProvider implements ServiceManagerAwareInterface {
    protected $itemMapper;
    protected $itemForm;
    protected $serviceManager;
    protected $options;
    protected $formHydrator;
    
    // Additional mappers needed
    protected $manufacturerMapper;
    
    public function add($item) {
        $entityClass = $this->getOptions()->getEntityClass("item");
        $form        = $this->getItemForm();

        $form->setHydrator($this->getFormHydrator());
        $form->bind(new $entityClass());
        $form->setData($item);

        if ($form->isValid()) {
            $item   = $form->getData();
            $events = $this->getEventManager();

            $events->trigger(__FUNCTION__, $this, compact('item', 'form'));
            $this->getItemMapper()->insert($item);
            $events->trigger(__FUNCTION__.'.post', $this, compact('item', 'form'));

            return $item;
        }
        return false;
    }
    
    public function findById($id) {
        $results = $this->events->trigger(__FUNCTION__.'.pre', $this, 
            array('id' => $id), 
            function ($result) {
                return ($result instanceof ItemEntity);
            }
        );
        if ($results->stopped()) { 
            return $results->last(); 
        }
        
        $item = $this->getItemMapper()->findById($id);
        
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('item' => $item));

        return $item;
    }
    
    public function findAll() {
        return $this->getItemMapper()->findAllByIdAndJoinOneToOne($this->getManufacturerMapper());
    }
    
    public function loadAllManufacturers() {
        return $this->getManufacturerMapper()->findAll();
    }
    
    public function update($item) {
        #$entityClass = $this->getOptions()->getEntityClass("item");
        $form        = $this->getItemForm();

        $form->setHydrator($this->getFormHydrator());
        $form->bind($item);
        #$form->setData($data);

        if ($form->isValid()) {
            $item   = $form->getData();
            $events = $this->getEventManager();

            $events->trigger(__FUNCTION__, $this, compact('item', 'form'));            
            $this->getItemMapper()->update($item);
            $events->trigger(__FUNCTION__.'.post', $this, compact('item', 'form'));

            return $item;
        }
        return false;
    }    
    
    public function setItemMapper(ItemMapperInterface $itemMapper)
    {
        $this->itemMapper = $itemMapper;
        return $this;
    }
    
    public function getItemMapper()
    {
        if (null === $this->itemMapper) {
            $this->setItemMapper($this->serviceManager->get('bidsite_item_mapper'));
        }
        return $this->itemMapper;
    }

    public function setManufacturerMapper(ManufacturerMapperInterface $manufacturerMapper)
    {
        $this->manufacturerMapper = $manufacturerMapper;
        return $this;
    }
    
    public function getManufacturerMapper()
    {
        if (null === $this->manufacturerMapper) {
            $this->setManufacturerMapper($this->serviceManager->get('bidsite_manufacturer_mapper'));
        }
        return $this->manufacturerMapper;
    }

    public function getItemForm()
    {
        if (null === $this->itemForm) {
            $this->setItemForm(
                $this->serviceManager->get('bidsite_item_form')
            );
        }
        return $this->itemForm;
    }

    public function setItemForm(Form $itemForm)
    {
        $this->itemForm = $itemForm;
        return $this;
    }
    
    public function getOptions()
    {
        if (!$this->options instanceof ServiceOptions) {
            $this->setOptions($this->serviceManager->get('bidsite_module_options'));
        }
        return $this->options;
    }

    public function setOptions(ServiceOptions $options)
    {
        $this->options = $options;
    }
    
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getFormHydrator()
    {
        if (!$this->formHydrator instanceof HydratorInterface) {
            $this->setFormHydrator(
                $this->serviceManager->get('bidsite_item_hydrator')
            );
        }

        return $this->formHydrator;
    }

    public function setFormHydrator(HydratorInterface $formHydrator)
    {
        $this->formHydrator = $formHydrator;
        return $this;
    }
}

?>