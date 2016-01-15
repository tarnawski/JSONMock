Feature: Manage applications
  In order to have possibility to administrate my applications
  As a user
  I need to be able to add, edit and remove my applications

  Background:
    Given There are the following applications:
      | ID | Name           | APP_KEY                     |
      | 1  | Application_1  | INHVFXSMDJWYKBOPQAZUCERLGT  |
      | 2  | Application_2  | YCMBXVDNELHOTJRQZGFPSWAKUI  |
      | 3  | Application_3  | NXYPBJZUVORQDFHAKLSMECGIWT  |

  @cleanDB
  Scenario: Get application details
    When I send a GET request to "/api/app/INHVFXSMDJWYKBOPQAZUCERLGT"
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "id": @integer@,
      "app_key":"@string@",
      "name":"@string@",
      "responses":"@array@"
    }
    """

  @cleanDB
  Scenario: Create new application
    When I send a POST request to "/api/app/" with body:
    """
    {
      "name":"name"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "id": @integer@,
      "app_key": "@string@",
      "name": "@string@",
      "responses": "@array@"
    }
    """

  @cleanDB
  Scenario: Create new application
    When I send a DELETE request to "/api/app/INHVFXSMDJWYKBOPQAZUCERLGT"
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "status": "@string@",
      "message": "@string@"
    }
    """