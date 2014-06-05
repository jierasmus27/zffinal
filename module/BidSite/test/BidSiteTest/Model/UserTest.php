<?php
/**
 * Class UserTest is used for unit testing the User Model
 * 
 * @author jierasmus27
 */
namespace BidSiteTest\Model;

use BidSite\Model\User;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase {
    
    /**
     * Test the initial state of the User object
     */
    public function testOrganisationInitialState() {
        $user = new User();
        
        $this->assertNull($user->id, '"id" should initially be null');
        $this->assertNull($user->email, '"email" should initially be null');
        $this->assertNull($user->first_name, '"first_name" should initially be null');
        $this->assertNull($user->last_name, '"last_name" should initially be null');
        $this->assertNull($user->password, '"password" should initially be null');
        $this->assertNull($user->salt, '"salt" should initially be null');
        $this->assertNull($user->status, '"status" should initially be null');
    }
    
    /**
     * Test that the exchangeArray method sets properties correctly
     */
    public function testExchangeArraySetsPropertiesCorrectly() {
        $data = array('id' => 1,
                      'email' => 'jierasmus@test',
                      'first_name' => 'Jaco',
                      'last_name' => 'Erasmus',
                      'password' => 'testtest',
                      'salt' => 'pepper',
                      'status' => 'active');
        $user = new User();
        $user->exchangeArray($data);
        
        $this->assertSame($data['id'], $user->id, "\"id\" not set correctly ({$data['id']})");
        $this->assertSame($data['email'], $user->email, '"email" not set correctly');
        $this->assertSame($data['first_name'], $user->first_name, '"first_name" not set correctly');
        $this->assertSame($data['last_name'], $user->last_name, '"last_name" not set correctly');
        $this->assertSame($data['password'], $user->password, '"password" not set correctly');
        $this->assertSame($data['salt'], $user->salt, '"salt" not set correctly');
        $this->assertSame($data['status'], $user->status, '"status" not set correctly');    
    }
    
    /**
     * Test that the exchangeArray method sets properties to null if keys missing
     */
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
        $data = array('id' => 1,
                      'email' => 'jierasmus@test',
                      'first_name' => 'Jaco',
                      'last_name' => 'Erasmus',
                      'password' => 'testtest',
                      'salt' => 'pepper',
                      'status' => 'active');
        $user = new User();
        $user->exchangeArray($data);
        
        $user->exchangeArray(array());
        $this->assertNull($user->id, '"id" should reset to null');
        $this->assertNull($user->email, '"email" should  reset to null');
        $this->assertNull($user->first_name, '"first_name" should reset to null');
        $this->assertNull($user->last_name, '"last_name" should reset to null');
        $this->assertNull($user->password, '"password" should reset to null');
        $this->assertNull($user->salt, '"salt" should reset to null');
        $this->assertNull($user->status, '"status" should reset to null');
    }
}


?>