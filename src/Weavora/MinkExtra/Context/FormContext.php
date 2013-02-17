<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;

/**
 * Form Context
 *
 * Class provide additional asserts and steps to fill and validate forms.
 */
class FormContext extends BaseContext
{
    /**
     * @Given /^I fill form with:$/
     */
    public function fillForm(TableNode $table)
    {
        $page = $this->getSession()->getPage();

        foreach ($table->getRows() as $row) {
            list($fieldSelector, $value) = $row;

            $field = $page->findField($fieldSelector);
            if (empty($field)) {
                $field = $this->getSession()->getDriver()->find('//label[contains(normalize-space(string(.)), "' . $fieldSelector . '")]');
                if (!empty($field)) {
                    $field = current($field);
                }
            }

            $tag = strtolower($field->getTagName());

            if ($tag == 'textarea') {
                $page->fillField($fieldSelector, $value);
            } elseif ($tag == 'select') {
                if ($field->hasAttribute('multiple')) {
                    foreach (explode(',', $value) as $index => $option) {
                        $page->selectFieldOption($fieldSelector, trim($option), true);
                    }
                } else {
                    $page->selectFieldOption($fieldSelector, $value);
                }
            } elseif ($tag == 'input') {
                $type = strtolower($field->getAttribute('type'));
                if ($type == 'checkbox' || $type == 'radio') {
                    if (strtolower($value) == 'yes') {
                        $page->checkField($fieldSelector);
                    } else {
                        $page->uncheckField($fieldSelector);
                    }
//                } elseif ($type == 'radio') {
//                    // TODO: handle radio
                } else {
                    $page->fillField($fieldSelector, $value);
                }
            } elseif ($tag == 'label') {
                foreach (explode(',', $value) as $option) {
                    $option = $this->fixStepArgument(trim($option));
                    $field->getParent()->checkField($option);
                }
            }
        }
    }

    /**
     * @Given /^I should see form with:$/
     */
    public function assertFormContain(TableNode $table)
    {
        foreach ($table->getRows() as $row) {
            list($field, $value) = $row;

            $node = $this->getSession()->getPage()->findField($field);
            if (empty($node)) {
                $node = $this->getSession()->getDriver()->find('//label[contains(normalize-space(string(.)), "' . $field . '")]');
                if (!empty($node)) {
                    $node = current($node);
                }
            }

            if (null === $node) {
                throw new \Behat\Mink\Exception\ElementNotFoundException($this->getSession(), 'form field', 'id|name|label|value', $field);
            }

            if ($node->getTagName() == 'input' && in_array($node->getAttribute('type'), array('checkbox', 'radio'))) {
                $actual = $node->isChecked() ? 'YES' : 'NO';
            } elseif ($node->getTagName() == 'select') {
                $actual = $node->getValue();
                if (!is_array($actual)) {
                    $actual = array($actual);
                }

                $options = array();
                $optionNodes = $this->getSession()->getDriver()->find($node->getXpath() . "/option");
                foreach($optionNodes as $optionNode) {
                    $options[$optionNode->getValue()] = $optionNode->getText();
                    $options[$optionNode->getText()] = $optionNode->getText();
                }
                foreach($actual as $index => $optionValue) {
                    if (isset($options[$optionValue])) {
                        $actual[$index] = $options[$optionValue];
                    }
                }
            } elseif ($node->getTagName() == 'label') {
                foreach (explode(',', $value) as $option) {
                    $option = $this->fixStepArgument(trim($option));
                    $this->assertSession()->checkboxChecked($option);
                }
                return true;
            } else {
                $actual = $node->getValue();
            }

            if (is_array($actual)) {
                $actual = join(',', $actual);
            }
            $regex = '/^' . preg_quote($value, '$/') . '/ui';

            if (!preg_match($regex, $actual)) {
                $message = sprintf('The field "%s" value is "%s", but "%s" expected.', $field, $actual, $value);
                throw new \Behat\Mink\Exception\ExpectationException($message, $this->getSession());
            }
        }
    }

    /**
     * @Given /^I fill in "(?P<field>(?:[^"]|\\")*)" with:$/
     */
    public function iFillInWith($field, PyStringNode $string)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($string->getRaw());
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @Given /^the "(?P<field>[^"]*)" field should contain:$/
     */
    public function assertFieldShouldContain($field, PyStringNode $string)
    {
        $this->assertSession()->fieldValueEquals($field, $string->getRaw());
    }

    /**
     * Checks, that form field with specified id|name|label|value has specified value.
     *
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" multiple field should contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertFieldContains($field, $value)
    {
        $node = $this->assertSession()->fieldExists($field);
        $actual = $node->getValue();
        if (is_array($actual)) {
            $actual = join(',', $actual);
        }
        $regex = '/^' . preg_quote($value, '$/') . '/ui';

        if (!preg_match($regex, $actual)) {
            $message = sprintf('The field "%s" value is "%s", but "%s" expected.', $field, $actual, $value);
            throw new \Behat\Mink\Exception\ExpectationException($message, $this->getSession());
        }
    }

    /**
     * Returns fixed step argument (with \\" replaced back to ").
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }
}
