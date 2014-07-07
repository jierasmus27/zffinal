<?php

/**
 * Hydrator for Item class
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

class ItemHydrator implements HydratorInterface {
    
    /**
     * Extract array from Item object
     * @param \BidSite\Entity\Item $item
     * @return array
     */
    public function extract($item) {
        $arrItem = array();
        $arrItem["id"] = ($item->id == "") ? null : $item->id;
        $arrItem["name"] = ($item->name == "") ? null : $item->name;
        $arrItem["model"] = ($item->model == "") ? null : $item->model;
        $arrItem["manufacturer_id"] = ($item->manufacturer->id == "") ? null : $item->manufacturer->id;
        if ($arrItem["manufacturer_id"] == null) {
            $arrItem["manufacturer_id"] = ($item->manufacturer_id == "") ? null : $item->manufacturer_id;
        }
        $arrItem["description"] = ($item->description == "") ? null : $item->description;
        return $arrItem;
    }
    
    /**
     * Hydrate an Item from data array
     * @param array $data
     * @param \BidSite\Entity\Item $item
     * @return \BidSite\Entity\Item $item
     */
    public function hydrate(array $data, $item) {
        $item->id = isset($data["id"]) ? $data["id"] : null;
        $item->name = isset($data["name"]) ? $data["name"] : null;
        $item->model = isset($data["model"]) ? $data["model"] : null;
        $item->manufacturer_id = isset($data["manufacturer_id"]) ? $data["manufacturer_id"] : null;
        
        $manufacturer = new \BidSite\Entity\Manufacturer();
        $manufacturer->id = isset($data["manufacturer_id"]) ? $data["manufacturer_id"] : null;
        $manufacturer->name = isset($data["manufacturer_name"]) ? $data["manufacturer_name"] : null;

        $item->manufacturer = $manufacturer;
        $item->description = isset($data["description"]) ? $data["description"] : null;
        return $item;
    }
}

?>