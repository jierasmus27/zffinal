<?php

/**
 * UserTableTest used to unit test the UserTable class
 *
 * @author jierasmus27
 */
namespace BidSiteTest\Model;

use BidSite\Model\UserTable;
use BidSite\Model\User;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class UserTableTest extends PHPUnit_Framework_TestCase {
    /**
     * Test that a fetchAll will return all users
     */
    public function testFetchAllReturnsAllUsers() {
        $resultSet = new ResultSet();        
        
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->will($this->returnValue($resultSet));
        $userTable = new UserTable($mockTableGateway);
        
        $this->assertSame($resultSet, $userTable->fetchAll());
    }
    
    /**
     * Test that a getUser will be retrieved correctly
     */
    public function testCanRetrieveUserById() {
        $user = new User();
        $data = array('id' => 1,
                      'email' => 'jierasmus@test',
                      'first_name' => 'Jaco',
                      'last_name' => 'Erasmus',
                      'password' => 'testtest',
                      'salt' => 'pepper',
                      'status' => 'active');
        $user->exchangeArray($data);
        
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());
        $resultSet->initialize(array($user));
        
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('ID' => 1))
                         ->will($this->returnValue($resultSet));
        
        $userTable = new UserTable($mockTableGateway);
        
        $this->assertSame($user, $userTable->getUser('1'));
    }
    
    /**
     * Test the correct exception is thrown when getUser is called with 
     * non-existent user id
     */
    public function testExceptionIsThrownWhenGettingNonexistentUserById() { 
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());
        $resultSet->initialize(array());
        
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('ID' => 1))
                         ->will($this->returnValue($resultSet));
        
        $userTable = new UserTable($mockTableGateway);
        try {
            $userTable->getUser('1');
        } catch (\Exception $e) {
            $this->assertSame($e->getMessage(), "Could not find user 1");
            return;
        }
        $this->fail("Correct User exception was not thrown");
    }
}

?>