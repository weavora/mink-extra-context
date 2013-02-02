@javascript
Feature: Form

	Scenario: Select field with multiple attribute should be properly asserted

		Given I am on "/form.php"
		When I select "MOption 1" from "Multiple Select"
		And I additionally select "MOption 3" from "Multiple Select"
		Then the "Multiple Select" multiple field should contain "1,3"


	Scenario: All form elements should be properly filled

		Given I am on "/form.php"
		When I fill form with:
			| Text				| text value			|
			| Checkbox			| YES					|
			| Select			| Option 2				|
			| Multiple Select	| MOption 2, MOption 3	|
			| Radio 2			| YES					|
			| Textarea			| textarea value		|
			| Checkbox Group	| Checkbox 1,Checkbox 3	|

		Then the "Text" field should contain "text value"
		And the "Checkbox" checkbox should be checked
		And the "Select" field should contain "2"
		And the "Multiple Select" multiple field should contain "2,3"
		And the "Radio 2" checkbox should be checked
		And the "Textarea" field should contain "textarea value"
		And the "Checkbox 1" checkbox should be checked
		And the "Checkbox 3" checkbox should be checked

	Scenario: All form elements should be properly asserted

		Given I am on "/form.php"
		When I fill in "Text" with "text value"
		And I check "Checkbox"
		And I select "Option 2" from "Select"
		And I select "MOption 1" from "Multiple Select"
		And I additionally select "MOption 2" from "Multiple Select"
		And I check "Radio 2"
		And I fill in "Textarea" with "textarea value"
		And I check "Checkbox 1"
		And I check "Checkbox 2"

		Then I should see form with:
			| Text				| text value			|
			| Checkbox			| YES					|
			| Select			| Option 2				|
			| Multiple Select	| MOption 1,MOption 2	|
			| Radio 2			| YES					|
			| Textarea			| textarea value		|
			| Checkbox Group	| Checkbox 1,Checkbox 2	|

	Scenario: It should be possible put multiline value to textarea
		Given I am on "/form.php"

		When I fill in "Textarea" with:
		"""
		Line 1
		Line 2
		Line 3
		"""

		Then the "Textarea" field should contain:
		"""
		Line 1
		Line 2
		Line 3
		"""