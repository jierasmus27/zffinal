<?php

/**
 * Description of AbstractEntityMapper
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;

abstract class AbstractEntityMapper extends AbstractDbMapper {
    protected $tableName;
    protected $databaseName;
    protected $tableIdentifier; 
    
    public function findById($id) {
        $select = new Select();
        $select->from($this->getTableIdentifier())->where(array('id' => $id));
        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }
    
    public function findAll() {
        $select = new Select();
        $select->from($this->getTableIdentifier());
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('resultSet' => $resultSet));
        return $resultSet;
    }
    
    public function insert($entity, $tableName = null, Hydrator $hydrator = null) {
        $hydrator = $hydrator ?: $this->getHydrator();
        $result = parent::insert($entity, $this->getTableIdentifier(), $hydrator);
        $hydrator->hydrate(array('id' => $result->getGeneratedValue()), $entity);
        return $result;
    }
    
    public function update($entity,
                           $where = null, $tableName = null, Hydrator $hydrator = null) {
        if (!$where) {
            $where = array('id' => $entity->getId());
        }
        
        if (!$tableName) {
            $tableName = $this->getTableName();
        }

        return parent::update($entity, $where, $this->getTableIdentifier(), $hydrator);
    }
    
    public function getTableName() {
        return $this->tableName;
    }
    
    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }
    
    public function getDatabaseName() {
        return $this->databaseName;
    }
    
    public function setDatabaseName($databaseName) {
        $this->databaseName = $databaseName;
    }
    
    public function getTableIdentifier() {
        if (!isset($this->tableIdentifier)) {
            $this->tableIdentifier = 
                new TableIdentifier($this->getTableName(), $this->getDatabaseName());
        }
        return $this->tableIdentifier;
    }
    
    public function setTableIdentifier($tableIdentifier) {
        $this->tableIdentifier = $tableIdentifier;
    }
}

?>