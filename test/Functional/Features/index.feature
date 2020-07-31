Feature: Index
  In order to use the wallbox API
  As an anonymous user
  I want to be able to see the API version

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
