<?php

/**
 * Interface for the user entity
 * @author jacoe
 */
namespace BidSite\Entity;

interface UserInterface {
    public function getId();
    public function getEmail();
    public function getLastName();
    public function getFirstName();
    public function getPassword();
    public function getSalt();
    public function getStatus();
    public function getRole();
    
    public function setId($id);
    public function setEmail($email);
    public function setLastName($last_name);
    public function setFirstName($first_name);
    public function setPassword($password);
    public function setSalt($salt);
    public function setStatus($status);
    public function setRole($role);
}

?>
