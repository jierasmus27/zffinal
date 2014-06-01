Feature: View All user details
  In order to edit a users details
  As a website admin user
  I need to view a specific users details

  Scenario: Edit a user details shows all details
    Given I am on "/user/view/1"
    Then I should see "View User Detai"
    And the "Email" field should contain "jaco.erasmus2@is.co.za"