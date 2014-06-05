Feature: Display an index of users
  In order to admin the bidsite
  As a website admin user
  I need to view an index of all users
  
  Scenario: Display a list of all users
    Given I am on "/user/index"
    Then I should see "My Users"
    And I should see "Add New User" 