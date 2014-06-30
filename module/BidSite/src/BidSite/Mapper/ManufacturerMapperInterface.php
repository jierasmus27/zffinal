<?php

/**
 * Interface for Manufacturers
 * @author jacoe
 */
namespace BidSite\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;

interface ManufacturerMapperInterface {
    public function findById($id);
    public function insert($manufacturer, $tableName = null, Hydrator $hydrator = null);
    public function update($manufacturer, $where = null, $tableName = null, Hydrator $hydrator = null);
}

?>