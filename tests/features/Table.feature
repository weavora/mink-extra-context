@javascript
Feature: Table

	Scenario: Table header should be properly asserted

		When I go to "/table.php"
		Then I should see main table header:
			| # | Name | Some options | Actions |
		And I should see "#" in main table header
		And I should see "Name" in main table header
		And I should see "Some options" in main table header
		And I should see "Actions" in main table header

	Scenario: Table rows should be properly asserted

		When I go to "/table.php"
		Then I should see main table rows:
			| # | Name   | Some options       |
			| 1 | Name 1 | Option 1, Option 2 |
			| 3 | Name 3 | Option 5, Option 6 |

	Scenario: Table cells should be properly asserted

		When I go to "/table.php"
		Then I should see "Option 1, Option 2" in main table row with "Name 1"
		And I should see "Option 3, Option 4" in 2nd main table row
		And "Some options" should contain "Option 5, Option 6" in main table row with "Name 3"
		And "Name" should contain "Name 2" in 2nd main table row
		And 2nd cell should contain "Name 3" in main table row with "Option 5, Option 6"
		And 3rd cell should contain "Option 1, Option 2" in 1st main table row

	Scenario: It should be easy to follow link in specified row

		When I go to "/table.php"
		Then I follow "Edit" in main table row with "Name 1"
		And I follow "Delete" in 2nd main table row

	Scenario: It should be easy to modify fields in specified row

		When I go to "/table.php"
		Then I check main table row with "Name 1"
		And I check 2nd main table row
		And I check "Label" in main table row with name "Name 2"
		And I check "Label" in 3rd main table row

