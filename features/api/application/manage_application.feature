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
    When I send a GET request to "/api/application/INHVFXSMDJWYKBOPQAZUCERLGT"
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
  Scenario: Get application details with wrong APP_KEY
    When I send a GET request to "/api/application/WRONGAPPKEY"
    Then the response code should be 404
    And the JSON response should match:
    """
    {
      "status": "Error",
      "message": "@string@"
    }
    """

  @cleanDB
  Scenario: Create application
    When I send a POST request to "/api/application" with body:
    """
    {
      "name":"name"
    }
    """
    Then the response code should be 201
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
  Scenario: Update application
    When I send a PUT request to "/api/application/NXYPBJZUVORQDFHAKLSMECGIWT" with body:
    """
    {
      "name":"Application_X"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "id": @integer@,
      "app_key": "@string@",
      "name": "Application_X",
      "responses": "@array@"
    }
    """

  @cleanDB
  Scenario: Update name application with wrong APP_KEY
    When I send a PUT request to "/api/application/WRONGAPPKEY" with body:
    """
    {
      "name":"name"
    }
    """
    Then the response code should be 404
    And the JSON response should match:
    """
    {
      "status": "Error",
      "message": "@string@"
    }
    """

  @cleanDB
  Scenario: Delete application
    When I send a DELETE request to "/api/application/INHVFXSMDJWYKBOPQAZUCERLGT"
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "status": "Success",
      "message": "@string@"
    }
    """

  @cleanDB
  Scenario: Delete application witch wrong APP_KEY
    When I send a DELETE request to "/api/application/WRONGAPPKEY"
    Then the response code should be 404
    And the JSON response should match:
    """
    {
      "status": "Error",
      "message": "@string@"
    }
    """

