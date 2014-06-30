<?php

/**
 * Description of Manufacturer
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use BidSite\Entity\ManufacturerInterface as ManufacturerEntityInterface;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;

class ManufacturerMapper extends AbstractEntityMapper implements ManufacturerMapperInterface {
    protected $tableName = "manufacturer";
    protected $databaseName = "zffinal";
    protected $tableIdentifier;
}

?>