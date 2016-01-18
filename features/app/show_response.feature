Feature: Show response
  In order to test Rest API
  As a user witch register application
  I need to be able to show my responses

  Background:
    Given There are the following applications:
      | ID | Name           | APP_KEY                     |
      | 1  | Application_1  | INHVFXSMDJWYKBOPQAZUCERLGT  |
      | 2  | Application_2  | YCMBXVDNELHOTJRQZGFPSWAKUI  |
    Given There are the following responses:
      | ID | Name           | Url                  | Value                 | Method | Status_code | APP_ID |
      | 1  | get category   | category             | {"category": "test"}  | GET    | 200         | 1      |
      | 2  | get product    | category/product/15  | {"product": "test"}   | GET    | 200         | 2      |

  @cleanDB
  Scenario: Get response
    When I send a GET request to "/app/INHVFXSMDJWYKBOPQAZUCERLGT/category"
    Then the JSON response should match:
    """
    {
      "category": "test"
    }
    """

  @cleanDB
  Scenario: Get response with invalid APP_KEY
    When I send a GET request to "/app/WRONGAPPKEY/category"
    Then the JSON response should match:
    """
    {
      "status": "Error",
      "message": "APP_KEY not match"
    }
    """

  @cleanDB
  Scenario: Get response
    When I send a GET request to "/app/INHVFXSMDJWYKBOPQAZUCERLGT/wrong"
    Then the JSON response should match:
    """
    {
      "status": "Error",
      "message": "Request not found"
    }
    """