@javascript
Feature: Table

	Scenario: Table header should be properly asserted

		When I go to "/table.php"
		Then I should see table header:
			| # | Name | Some options | Actions |
		And I should see "#" in table header
		And I should see "Name" in table header
		And I should see "Some options" in table header
		And I should see "Actions" in table header

	Scenario: Table rows should be properly asserted

		When I go to "/table.php"
		Then I should see table rows:
			| # | Name   | Some options       |
			| 1 | Name 1 | Option 1, Option 2 |
			| 3 | Name 3 | Option 5, Option 6 |

	Scenario: Table cells should be properly asserted

		When I go to "/table.php"
		Then I should see "Option 1, Option 2" in table row with "Name 1"
		And I should see "Option 3, Option 4" in 2nd table row
		And "Some options" should contain "Option 5, Option 6" in table row with "Name 3"
		And "Name" should contain "Name 2" in 2nd table row
		And 2nd cell should contain "Name 3" in table row with "Option 5, Option 6"
		And 3rd cell should contain "Option 1, Option 2" in 1st table row

	Scenario: It should be easy to follow link in specified row

		When I go to "/table.php"
		Then I follow "Edit" in table row with "Name 1"
		And I follow "Delete" in 2nd table row

	Scenario: It should be easy to modify fields in specified row

		When I go to "/table.php"
		Then I check table row with "Name 1"
		And I check 2nd table row
		And I check "Label" in table row with name "Name 2"
		And I check "Label" in 3rd table row

