# Mink Extra Context

Mink Extra Context provide additional contexts for behat/mink

## Installation

This extension requires:

* Behat 2.4+
* Mink 1.4+
* Mink extension

### Through Composer

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

Step 3. Activate mink extra context extension by specifying its class in your ``behat.yml``:

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

Most common issue with browser session when element can't be found because page haven't loaded yet or ajax request is still processing.
Page context allow you to stop worry about page loading time or ajax requests without hooking features with tons of wait statements.

What page context perform is inject special javascript page-wait conditions into every request related step (like click, go to and etc).

## Form Context

Filling forms is often annoying task. Form context help you keep your form related features more structurized.

Usage examples:

### Fill form

```gherkin
    Scenario: Create new post
        Given I am logged in as blogger@gmail.com
        When I go to "/post/create"
        And I fill form with:
            | Title       | Awesome post                 |
            | Content     | This is post about awesomess |
            | Status      | Draft                        |
            | Tags        | awesome,test-tag,create      |
            | Category    | Test                         |
        And I press "Save"
        ...
```

### Check form

```gherkin
    Scenario: Edit exits post
        Given I am logged in as blogger@gmail.com
        When I go to "/post/edit/1"
        Then I should see form with:
            | Title       | Awesome post                 |
            | Content     | This is post about awesomess |
            | Is Draft    | Yes                          |
            | Tags        | awesome,test-tag,create      |
            | Category    | Test                         |
```

### Textareas

```gherkin
    Scenario: Fill and assert textarea content
        Given I am logged in as blogger@gmail.com

        When I go to "/post/edit/1"
        Then the "Content" field should contains:
        """
        Awesome and
        what's important
        multiline content
        """
        And I fill in "Content" with:
        """
         - nice to have multiline support...
         - yeah!
        """
```

### Notes

1. Extension uses standard selectors to find fields. So you can use label selectors (like Title or Content) or name selectors (like post_form[title] or post_form[content])
2. Extension support all field types like textarea, select, input and etc.
