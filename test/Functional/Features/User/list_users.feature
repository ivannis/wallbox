@user
Feature: List users
  In order to use the wallbox API
  As an anonymous user
  I want to be able to see the user list.

  Background:
    Given the current date-time is "2019-10-28 13:15:00"
    And the following users exists:
      | id | name     | surname    | email                     | country | createdAt  | activatedAt | chargerId |
      | 1  | Lillian  | Harvey     | lharvey0@oracle.com       | ES      | 2015-12-06 | 2015-12-25  | 1         |
      | 2  | Robin    | Gonzalez   | rgonzalez1@washington.edu | VN      | 2015-12-05 | 2015-12-16  | 2         |
      | 3  | Antonio  | Thompson   | athompson2@wp.com         | ES      | 2015-12-02 | 2015-12-12  | 3         |
      | 4  | Diana    | Weaver     | dweaver3@myspace.com      | VN      | 2015-12-04 | 2015-12-20  | 4         |
      | 5  | Emily    | Mills      | emills4@flickr.com        | CN      | 2015-12-04 | 2015-12-18  | 5         |
      | 6  | Alan     | Richardson | arichardson1k@oracle.com  | ES      | 2015-12-05 | 2015-12-12  | 6         |

  Scenario: List all users
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/"
    Then the response status code should be 200
    And the response should be equal to JSON:
    """
    [
      {
          "id": 6,
          "name": "Alan",
          "surname": "Richardson",
          "email": "arichardson1k@oracle.com",
          "country": "ES",
          "createAt": "20151205",
          "activateAt": "20151212",
          "chargerId": 6
      },
      {
          "id": 3,
          "name": "Antonio",
          "surname": "Thompson",
          "email": "athompson2@wp.com",
          "country": "ES",
          "createAt": "20151202",
          "activateAt": "20151212",
          "chargerId": 3
      },
      {
          "id": 4,
          "name": "Diana",
          "surname": "Weaver",
          "email": "dweaver3@myspace.com",
          "country": "VN",
          "createAt": "20151204",
          "activateAt": "20151220",
          "chargerId": 4
      },
      {
          "id": 5,
          "name": "Emily",
          "surname": "Mills",
          "email": "emills4@flickr.com",
          "country": "CN",
          "createAt": "20151204",
          "activateAt": "20151218",
          "chargerId": 5
      },
      {
          "id": 1,
          "name": "Lillian",
          "surname": "Harvey",
          "email": "lharvey0@oracle.com",
          "country": "ES",
          "createAt": "20151206",
          "activateAt": "20151225",
          "chargerId": 1
      },
      {
          "id": 2,
          "name": "Robin",
          "surname": "Gonzalez",
          "email": "rgonzalez1@washington.edu",
          "country": "VN",
          "createAt": "20151205",
          "activateAt": "20151216",
          "chargerId": 2
      }
  ]
  """

  Scenario: List all users for a given country list
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/" with parameters:
      | key       | value |
      | countries | VN,CN |
    Then the response status code should be 200
    And the response should be equal to JSON:
    """
    [
      {
          "id": 4,
          "name": "Diana",
          "surname": "Weaver",
          "email": "dweaver3@myspace.com",
          "country": "VN",
          "createAt": "20151204",
          "activateAt": "20151220",
          "chargerId": 4
      },
      {
          "id": 5,
          "name": "Emily",
          "surname": "Mills",
          "email": "emills4@flickr.com",
          "country": "CN",
          "createAt": "20151204",
          "activateAt": "20151218",
          "chargerId": 5
      },
      {
          "id": 2,
          "name": "Robin",
          "surname": "Gonzalez",
          "email": "rgonzalez1@washington.edu",
          "country": "VN",
          "createAt": "20151205",
          "activateAt": "20151216",
          "chargerId": 2
      }
    ]
    """

  Scenario: List all users with 15 or more days between the registration date and the activation date
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/" with parameters:
      | key               | value |
      | activation_length | 15    |
    Then the response status code should be 200
    And the response should be equal to JSON:
    """
    [
      {
          "id": 4,
          "name": "Diana",
          "surname": "Weaver",
          "email": "dweaver3@myspace.com",
          "country": "VN",
          "createAt": "20151204",
          "activateAt": "20151220",
          "chargerId": 4
      },
      {
          "id": 1,
          "name": "Lillian",
          "surname": "Harvey",
          "email": "lharvey0@oracle.com",
          "country": "ES",
          "createAt": "20151206",
          "activateAt": "20151225",
          "chargerId": 1
      }
    ]
    """

  Scenario: List all users from Spain with 10 or more days between the registration date and the activation date
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/" with parameters:
      | key               | value |
      | countries         | ES    |
      | activation_length | 10    |
    Then the response status code should be 200
    And the response should be equal to JSON:
    """
    [
      {
          "id": 3,
          "name": "Antonio",
          "surname": "Thompson",
          "email": "athompson2@wp.com",
          "country": "ES",
          "createAt": "20151202",
          "activateAt": "20151212",
          "chargerId": 3
      },
      {
          "id": 1,
          "name": "Lillian",
          "surname": "Harvey",
          "email": "lharvey0@oracle.com",
          "country": "ES",
          "createAt": "20151206",
          "activateAt": "20151225",
          "chargerId": 1
      }
    ]
    """

  Scenario: List all users for United State
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/" with parameters:
      | key               | value |
      | countries         | US    |
    Then the response status code should be 200
    And the response should be an empty JSON array

  Scenario: Request the user list with invalid country
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a "GET" request to "/v1/users/" with parameters:
      | key               | value     |
      | countries         | Neverland |
      | activation_length | foo       |
    Then the response status code should be 400
    And the response should be equal to JSON:
    """
    {
        "code": 400,
        "message": "Bad request",
        "reason": "UNPROCESSABLE_ENTITY",
        "errors": {
            "countries": "The countries must contain valid countries Iso2 codes",
            "activation_length": "The activation length must be an integer."
        }
    }
    """
