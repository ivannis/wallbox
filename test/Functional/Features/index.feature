Feature: Index
  In order to use the wallbox api
  As a wallbox user
  I want to be able to ....

  Scenario: test
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/"
    Then the response status code should be 200
    And the response should be in JSON
    And the response should be equal to JSON:
    """
      {
        "version": "Wallbox API version 1.0.0"
      }
    """
    And print last response
    And print last response headers
