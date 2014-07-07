<?php

/**
 * Hydrator for User class
 *
 * @author jacoe
 */
namespace BidSite\Mapper;

class UserHydrator implements HydratorInterface {
    
    /**
     * Extract array from User object
     * @param \BidSite\Entity\User $user
     * @return array
     */
    public function extract($user) {
        $arrUser = array();
        $arrUser["id"] = ($user->id == "") ? null : $user->id;
        $arrUser["email"] = ($user->email == "") ? null : $user->email;
        $arrUser["first_name"] = ($user->first_name == "") ? null : $user->first_name;
        $arrUser["last_name"] = ($user->last_name == "") ? null : $user->last_name;
        $arrUser["password"] = ($user->password == "") ? null : $user->password;
        $arrUser["salt"] = ($user->salt == "") ? null : $user->salt;
        $arrUser["status"] = ($user->status == "") ? null : $user->status;
        $arrUser["role"] = ($user->role == "") ? null : $user->role;
        return $arrUser;
    }
    
    /**
     * Hydrate an User from data array
     * @param array $data
     * @param \BidSite\Entity\User $user
     * @return \BidSite\Entity\User $user
     */
    public function hydrate(array $data, $user) {
        $user->id = isset($data["id"]) ? $data["id"] : null;
        $user->email = isset($data["email"]) ? $data["email"] : null;
        $user->first_name = isset($data["first_name"]) ? $data["first_name"] : null;
        $user->last_name = isset($data["last_name"]) ? $data["last_name"] : null;
        $user->password = isset($data["password"]) ? $data["password"] : null;
        $user->salt = isset($data["salt"]) ? $data["salt"] : null;
        $user->status = isset($data["status"]) ? $data["status"] : null;
        $user->role = isset($data["role"]) ? $data["role"] : null;
        return $user;
    }
}

?>