<?php

/**
 * Description of Item
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use BidSite\Entity\ItemInterface as ItemEntityInterface;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;
use Zend\Db\Sql\Select;

class ItemMapper extends AbstractEntityMapper implements ItemMapperInterface {
    protected $tableName = "item";
    protected $databaseName = "zffinal";
    protected $tableIdentifier;
    
    public function findAllByName($name) {
        $select = new Select();
        $select->from($this->getTableIdentifier())->where(array('name' => $name));
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('resultSet' => $resultSet));
        return $resultSet;
    }
    
    public function findAllByIdAndJoinOneToOne($manufacturerMapper) {
        $select = new Select();
        $select->from(array("i" => $this->getTableIdentifier()))
               ->join(array("m" => $manufacturerMapper->getTableIdentifier()), 
                      "i.manufacturer_id = m.id",
                      array("manufacturer_name" => "name"));
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('resultSet' => $resultSet));

        return $resultSet;
    }
    
    public function findAllByModel($model) {
        $select = $this->getSelect()
                       ->where(array('model' => $model));
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('entities' => $resultSet));
        return $resultSet;
    }
    
    public function findAllByManufacturerId($manufacturer_id) {
        $select = $this->getSelect()
                       ->where(array('manufacturer_id' => $manufacturer_id));
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('entities' => $resultSet));
        return $resultSet;
    }
    
    public function getHydrator() {
        if (!$this->hydrator) {
            $this->hydrator = new ItemHydrator(false);
        }
        return $this->hydrator;
    }
}

?>