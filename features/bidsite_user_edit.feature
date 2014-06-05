Feature: Edit web user details
  In order to manage my users
  As a website admin user
  I need to edit a users details

  Scenario: Edit a user details shows all details
    Given I am on "/user/edit/1"
    Then I should see "Edit User Details"
    And the "Email" field should contain "jaco.erasmus2@is.co.za"