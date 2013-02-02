@javascript
Feature: Page

	Scenario: Element selectors should wait before page loads

		When I go to "/slow_page.php"
		Then I should see "some text" in the ".content" element

		When I am on "/slow_page.php"
		Then I should see "some text" in the ".content" element

		When I follow "link"
		Then I should see "some text" in the ".content" element

		When I press "Submit"
		Then I should see "some text" in the ".content" element
