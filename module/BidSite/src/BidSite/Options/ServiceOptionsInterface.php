<?php

/**
 * Interface for Module Options 
 * @author jacoe
 */
namespace BidSite\Options;

interface ServiceOptionsInterface {
    public function setTableName($entity, $tableName);
    public function getTableName($entity);
    public function setEntityClass($entity, $entityClass);
    public function getEntityClass($entity);
}

?>