<?php

/**
 * Interface for Item Entity
 * @author jacoe
 */
namespace BidSite\Entity;

interface ItemInterface {
    public function getId();
    public function getName();
    public function getModel();
    public function getManufacturer();
    public function getDescription();
}

?>