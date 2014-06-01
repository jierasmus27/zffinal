Feature: View user details
  In order to see user details
  As a website admin user
  I need to be able to search for a word

  Scenario: Searching for a page that does exist
    Given I am on "/user/1"
    Then I should see "View User"