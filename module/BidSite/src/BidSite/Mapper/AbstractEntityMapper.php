<?php

/**
 * AbstractEntityMapper to map database to entities
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;

abstract class AbstractEntityMapper extends AbstractDbMapper {
    
    /**
     * @var string 
     */
    protected $tableName;
    
    /**
     * @var string 
     */
    protected $databaseName;
    
    /**
     * @var \Zend\Db\Sql\TableIdentifier
     */
    protected $tableIdentifier; 
    
    /**
     * Return an entity based on id
     * @param int $id
     * @return var
     */
    public function findById($id) {
        $select = new Select();
        $select->from($this->getTableIdentifier())->where(array('id' => $id));
        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }
    
    /**
     * Return All instances of the entity
     * @return array
     */
    public function findAll() {
        $select = new Select();
        $select->from($this->getTableIdentifier());
        $resultSet = $this->select($select);
        $this->getEventManager()->trigger('find', $this, array('resultSet' => $resultSet));
        return $resultSet;
    }
    
    /**
     * Insert entity into database
     * @param var $entity
     * @param string $tableName
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $hydrator
     * @return \Zend\Db\Sql\Result result
     */
    public function insert($entity, $tableName = null, Hydrator $hydrator = null) {
        $hydrator = $hydrator ?: $this->getHydrator();
        $result = parent::insert($entity, $this->getTableIdentifier(), $hydrator);
        $hydrator->hydrate(array('id' => $result->getGeneratedValue()), $entity);
        return $result;
    }
    
    /**
     * Update an existing entity
     * @param var $entity
     * @param string $where
     * @param type $tableName
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $hydrator
     * @return \Zend\Db\Sql\Result result
     */
    public function update($entity,
                           $where = null, $tableName = null, Hydrator $hydrator = null) {
        if (!$where) {
            $where = array('id' => $entity->getId());
        }
        
        if (!$tableName) {
            $tableName = $this->getTableName();
        }

        return parent::update($entity, $where, $this->getTableIdentifier(), $this->getHydrator());
    }
    
    /**
     * Return database table name
     * @return string
     */
    public function getTableName() {
        return $this->tableName;
    }
    
    /**
     * Set database Table name
     * @param string $tableName
     * @return \BidSite\Mapper\AbstractEntityMapper
     */
    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }
    
    /**
     * Return Database Name
     * @return string
     */
    public function getDatabaseName() {
        return $this->databaseName;
    }
    
    /**
     * Set Database Name
     * @param string $databaseName
     */
    public function setDatabaseName($databaseName) {
        $this->databaseName = $databaseName;
    }
    
    /**
     * Return table identfier
     * @return \Zend\Db\Sql\TableIdentifier
     */
    public function getTableIdentifier() {
        if (!isset($this->tableIdentifier)) {
            $this->tableIdentifier = 
                new TableIdentifier($this->getTableName(), $this->getDatabaseName());
        }
        return $this->tableIdentifier;
    }
    
    /**
     * Set table identifier
     * @param \Zend\Db\Sql\TableIdentifier $tableIdentifier
     */
    public function setTableIdentifier($tableIdentifier) {
        $this->tableIdentifier = $tableIdentifier;
    }
}

?>