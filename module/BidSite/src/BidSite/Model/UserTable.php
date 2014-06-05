<?php

/**
 * UserTable class used to manage User database data
 *
 * @author jacoe
 */
namespace BidSite\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable {
    protected $tableGateway;
    
    /**
     * Construct the UserTable object
     * 
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * Return All Users
     * 
     * @return ResultSet 
     */
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    /**
     * Return a specific User by id
     * 
     * @param int $id
     * @return $row
     * @throws \Exception when no user with matching id is found
     */
    public function getUser($id) {
        $id = (int) $id;
        $resultSet = $this->tableGateway->select(array('ID' => $id));
        $rowSet = $resultSet->current();
        if (!$rowSet) {
            throw new \Exception("Could not find user $id");
        }
        return $rowSet;
    }
}

?>