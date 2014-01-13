# Mink Extra Context

Mink Extra Context provides additional contexts for behat/mink

## Installation

This extension requires:

* Behat 2.4+
* Mink 1.4+
* Mink extension

### Via Composer

Step 1. Define dependencies in your ``composer.json``:

```js

{
    "require": {
        ...
        "weavora/mink-extra-context": "*"
    }
}
```

Step 2. Install/update your vendors:

```bash

    # install
    $ curl http://getcomposer.org/installer | php
    $ php composer.phar install

    # or update
    $ php composer.phar update
```

Step 3. Activate a mink extra context extension by specifying its class in your ``behat.yml``:

```yaml

    # behat.yml
    default:
        # ...
        extensions:
            # ...
            Weavora\MinkExtra\Extension:
                form: true
                table: true
                page: true
                page_area: true

```

Step 4. Add MinkExtraContext to your FeatureContent

```php

class FeatureContext extends \Behat\MinkExtension\Context\MinkContext
{

    public function __construct(array $parameters)
    {
        // ...
        $this->useContext('mink-extra', new \Weavora\MinkExtra\Context\MinkExtraContext());
    }
}
```


## Page Context

The most common issue with a browser session is a situation when an element can't be found because the page haven't been loaded yet or ajax request is still being processed.
Page context allows you to stop worrying about page loading time or ajax requests with no hooking features but tons of wait statements.

What page context performs is injecting special javascript page-wait conditions into every request related step (like click, go to and etc).

## Form Context

Filling in forms is often an annoying task. Form context helps you keep your form related features more structured.

Usage examples:

### Fill in forms

```gherkin
	Scenario: All form elements should be properly filled in

		Given I am on "/tests/pages/form.php"
		When I fill in the form with:
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
```

### Check forms

```gherkin
	Scenario: All form elements should be properly asserted

		Given I am on "/tests/pages/form.php"
		When I fill in "Text" with "text value"
		And I check "Checkbox"
		And I select "Option 2" from "Select"
		And I select "MOption 1" from "Multiple Select"
		And I additionally select "MOption 2" from "Multiple Select"
		And I check "Radio 2"
		And I fill in "Textarea" with "textarea value"
		And I check "Checkbox 1"
		And I check "Checkbox 2"

		Then I should see the form with:
			| Text				| text value			|
			| Checkbox			| YES					|
			| Select			| Option 2				|
			| Multiple Select	| MOption 1,MOption 2	|
			| Radio 2			| YES					|
			| Textarea			| textarea value		|
			| Checkbox Group	| Checkbox 1,Checkbox 2	|
```

### Textareas

```gherkin
	Scenario: It should be possible to set a multiline value to textarea
		Given I am on "/tests/pages/form.php"

		When I fill in "Textarea" with:
		"""
		Line 1
		Line 2
		Line 3
		"""

		The "Textarea" field should contain:
		"""
		Line 1
		Line 2
		Line 3
		"""
```

### Multiple select value asserts

```gherkin
	Scenario: A select field with multiple attributes should be properly asserted

		Given I am on "/form.php"
		When I select "MOption 1" from "Multiple Select"
		And I additionally select "MOption 3" from "Multiple Select"
		The "Multiple Select" multiple field should contain "1,3"
```

### Notes

1. The extension uses standard selectors to find fields. So you can use label selectors (like Title or Content) or name selectors (like post_form[title] or post_form[content])
2. The extension supports all field types like textarea, select, input,etc.
