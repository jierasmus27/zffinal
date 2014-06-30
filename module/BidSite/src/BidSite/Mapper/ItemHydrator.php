<?php

/**
 * Hydrator for Item class
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

//use Zend\Stdlib\Hydrator\

class ItemHydrator implements HydratorInterface {
    public function extract($item) {
        $arrItem = array();
        $arrItem["id"] = ($item->id == "") ? null : $item->id;
        $arrItem["name"] = ($item->name == "") ? null : $item->name;
        $arrItem["model"] = ($item->model == "") ? null : $item->model;
        $arrItem["manufacturer_id"] = ($item->manufacturer->id == "") ? null : $item->manufacturer->id;
        $arrItem["manufacturer"] = ($item->manufacturer == "") ? null : $item->manufacturer;
        $arrItem["manufacturer"]->id = ($item->manufacturer->id == "") ? null : $item->manufacturer->id;
        $arrItem["manufacturer"]->name = "test"; //($item->manufacturer->name == "") ? null : $item->manufacturer->name;
        $arrItem["description"] = ($item->description == "") ? null : $item->description;
        return $arrItem;
    }
    
    public function hydrate(array $data, $item) {
        print_r($data);
        $item->id = isset($data["id"]) ? $data["id"] : null;
        $item->name = isset($data["name"]) ? $data["name"] : null;
        $item->model = isset($data["model"]) ? $data["model"] : null;
        
        $manufacturer = new \BidSite\Entity\Manufacturer();
        $manufacturer->id = isset($data["manufacturer_id"]) ? $data["manufacturer_id"] : null;
        $manufacturer->name = isset($data["manufacturer_name"]) ? $data["manufacturer_name"] : null;

        $item->manufacturer = $manufacturer;
        $item->description = isset($data["description"]) ? $data["description"] : null;
        return $item;
    }
}

?>