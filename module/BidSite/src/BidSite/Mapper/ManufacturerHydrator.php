<?php

/**
 * Hydrator for Manufacturer class
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;

class ManufacturerHydrator extends ClassMethods implements HydratorInterface {
    public function extract($manufacturer) {
        $arrManufacturer = array();
        $arrManufacturer["id"] = ($manufacturer->id == "") ? null : $manufacturer->id;
        $arrManufacturer["name"] = ($manufacturer->name == "") ? null : $manufacturer->name;
        return $arrManufacturer;
    }
    
    public function hydrate(array $data, $manufacturer) {
        $manufacturer->id = isset($data["id"]) ? $data["id"] : null;
        $manufacturer->name = isset($data["name"]) ? $data["name"] : null;
        return $manufacturer;
    }
}

?>