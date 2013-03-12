@javascript
Feature: Page Areas

	Scenario: Area selectors works fine

		When I go to "/page_area.php"

		Then I should see "Content" in content area
		And I should not see "Body2" in content area

		Then I follow "Section" in menu area

		And I should see "user1" in users area
