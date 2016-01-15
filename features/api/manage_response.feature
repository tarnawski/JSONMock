Feature: Manage response
  In order to mock HTTP responses i must have possibility to administrate my responses
  As a user witch register application
  I need to be able to add, edit and remove my responses

  Background:
    Given There are the following applications:
      | ID | Name           | APP_KEY                     |
      | 1  | Application_1  | INHVFXSMDJWYKBOPQAZUCERLGT  |
      | 2  | Application_2  | YCMBXVDNELHOTJRQZGFPSWAKUI  |
#    Given There are the following responses:
#      | ID | Name           | URL                  | VALUE                   | METHOD | STATUS_CODE | APP_ID |
#      | 1  | get category   | category             | [{"category": "test"}]  | GET    | 200         | 1      |
#      | 2  | get product    | category/product/15  | [{"product": "test"}]   | GET    | 200         | 2      |

  @cleanDB
  Scenario: Get response
    When I send a GET request to "/app/INHVFXSMDJWYKBOPQAZUCERLGT/category"
    Then the JSON response should match:
    """
    {
      "error": "Error",
      "message": "fd"
    }
    """