<?php

/**
 * Interface for Items
 * @author jacoe
 */
namespace BidSite\Mapper;

use BidSite\Entity\ItemInterface as ItemEntityInterface;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;

interface ItemMapperInterface {
    public function findById($id);
    public function findAllByName($name);
    public function findAllByModel($model);
    public function findAllByManufacturerId($manufacturer_id);
    public function insert($item, $tableName = null, Hydrator $hydrator = null);
    public function update($item, $where = null, $tableName = null, Hydrator $hydrator = null);
}

?>