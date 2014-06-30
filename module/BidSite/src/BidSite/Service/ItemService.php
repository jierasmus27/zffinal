<?php

/**
 * Item Service class
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
    
    /**
     * Add a new Item
     * @param \BidSite\Entity\Item $item
     * @return boolean
     */
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
    
    /**
     * Find an Item based on Id
     * @param int $id
     * @return \BidSite\Entity\Item
     */
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
    
    /**
     * Return all Items and join one-to-one db relationships
     * @return array
     */
    public function findAll() {
        return $this->getItemMapper()->findAllByIdAndJoinOneToOne($this->getManufacturerMapper());
    }
    
    /**
     * Get all Manufacturers
     * @return array
     */
    public function loadAllManufacturers() {
        return $this->getManufacturerMapper()->findAll();
    }
    
    /**
     * Update an Item entity
     * @param \BidSite\Entity\Item $item
     * @return boolean
     */
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
    
    /**
     * Set the Item mapper
     * @param \BidSite\Mapper\ItemMapperInterface $itemMapper
     * @return \BidSite\Service\ItemService
     */
    public function setItemMapper(ItemMapperInterface $itemMapper)
    {
        $this->itemMapper = $itemMapper;
        return $this;
    }
    
    /**
     * Return Item Mapper
     * @return \BidSite\Mapper\ItemMapperInterface
     */
    public function getItemMapper()
    {
        if (null === $this->itemMapper) {
            $this->setItemMapper($this->serviceManager->get('bidsite_item_mapper'));
        }
        return $this->itemMapper;
    }

    /**
     * Set Manufacturer mapper
     * @param \BidSite\Mapper\ManufacturerMapperInterface $manufacturerMapper
     * @return \BidSite\Service\ItemService
     */
    public function setManufacturerMapper(ManufacturerMapperInterface $manufacturerMapper)
    {
        $this->manufacturerMapper = $manufacturerMapper;
        return $this;
    }
    
    /**
     * Return Manufacturer mapper
     * @return \BidSite\Mapper\ManufacturerMapper
     */
    public function getManufacturerMapper()
    {
        if (null === $this->manufacturerMapper) {
            $this->setManufacturerMapper($this->serviceManager->get('bidsite_manufacturer_mapper'));
        }
        return $this->manufacturerMapper;
    }

    /**
     * Return Item form
     * @return \BidSite\Form\ItemForm
     */
    public function getItemForm()
    {
        if (null === $this->itemForm) {
            $this->setItemForm(
                $this->serviceManager->get('bidsite_item_form')
            );
        }
        return $this->itemForm;
    }

    /**
     * Set Item form
     * @param \Zend\Form\FormInterface $itemForm
     * @return \BidSite\Service\ItemService
     */
    public function setItemForm(Form $itemForm)
    {
        $this->itemForm = $itemForm;
        return $this;
    }
    
    /**
     * Return Module Options
     * @return \BidSite\Options\ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ServiceOptions) {
            $this->setOptions($this->serviceManager->get('bidsite_module_options'));
        }
        return $this->options;
    }

    /**
     * Set Module Options
     * @param \BidSite\Options\ServiceOptionsInterface $options
     */
    public function setOptions(ServiceOptions $options)
    {
        $this->options = $options;
    }
    
    /**
     * Return Service Manager
     * @return string
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set Service Manager
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     * @return \BidSite\Service\ItemService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Return Item form Hydrator
     * @return \BidSite\Mapper\ItemHydrator
     */
    public function getFormHydrator()
    {
        if (!$this->formHydrator instanceof HydratorInterface) {
            $this->setFormHydrator(
                $this->serviceManager->get('bidsite_item_hydrator')
            );
        }

        return $this->formHydrator;
    }

    /**
     * Set Item form Hydrator
     * @param \BidSite\Mapper\HydratorInterface $formHydrator
     * @return \BidSite\Service\ItemService
     */
    public function setFormHydrator(HydratorInterface $formHydrator)
    {
        $this->formHydrator = $formHydrator;
        return $this;
    }
}

?>