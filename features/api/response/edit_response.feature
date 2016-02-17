Feature: Manage response
  In order to mock HTTP responses i must have possibility to administrate my responses
  As a user witch register application
  I need to be able to add, edit and remove my responses

  Background:
    Given There are the following applications:
      | ID | Name           | APP_KEY                     |
      | 1  | Application_1  | INHVFXSMDJWYKBOPQAZUCERLGT  |
      | 2  | Application_2  | YCMBXVDNELHOTJRQZGFPSWAKUI  |
    Given There are the following responses:
      | ID | Name           | Url                  | Value                 | Method | Status_code | APP_ID |
      | 1  | get category   | category             | {"category": "test"}  | GET    | 200         | 1      |
      | 2  | get product    | category/product/15  | {"product": "test"}   | GET    | 200         | 1      |

  @cleanDB
  Scenario: Edit response
    When I send a PUT request to "/api/response/INHVFXSMDJWYKBOPQAZUCERLGT/1" with body:
    """
    {
       "name": "nowa",
       "url": "nowy",
       "value": {"category": "test"},
       "method": "DELETE",
       "statusCode": "500"
    }
    """
    Then the response code should be 200
    Then the JSON response should match:
    """
      {
        "id": @integer@,
        "name": "nowa",
        "url": "nowy",
        "value": {"category": "test"},
        "method": "DELETE",
        "status_code": 500
      }
    """

  @cleanDB
  Scenario: Edit response with not unique parameters
    When I send a PUT request to "/api/response/INHVFXSMDJWYKBOPQAZUCERLGT/1" with body:
    """
    {
       "name": "nowa",
       "url": "category/product/15",
       "value": {"category": "test"},
       "method": "GET",
       "statusCode": "500"
    }
    """
    Then the response code should be 400
    Then the JSON response should match:
    """
    {
      "status": "Error",
      "message": "Response exist" 
    }
    """

  @cleanDB
  Scenario: Edit response with invalid APP_KEY
    When I send a PUT request to "/api/response/WRONGAPPKEY/1" with body:
    """
    {
       "name": "nowa",
       "url": "category",
       "value": {"category": "test"},
       "method": "GET",
       "statusCode": "500"
    }
    """
    Then the response code should be 404
    Then the JSON response should match:
    """
    {
      "status": "Error",
      "message": "APP_KEY not match"
    }
    """

  @cleanDB
  Scenario: Edit response with invalid ID
    When I send a PUT request to "/api/response/INHVFXSMDJWYKBOPQAZUCERLGT/5" with body:
    """
    {
       "name": "nowa",
       "url": "nowy",
       "value": {"category": "test"},
       "method": "DELETE",
       "statusCode": "500"
    }
    """
    Then the response code should be 404
    Then the JSON response should match:
    """
    {
      "status": "Error",
      "message": "Response not found"
    }
    """
