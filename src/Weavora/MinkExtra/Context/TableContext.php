<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;

/**
 * Table Context
 *
 * Class provide additional steps to asserts table content
 */
class TableContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * @Then /^I should see table header:$/
     */
    public function assertTableHeader(TableNode $headers)
    {
        /** @var $targetHeaders NodeElement[] */
        $targetHeaders = $this->getSession()->getPage()->findAll('css', 'table th');
        if (count($targetHeaders) != count($headers->getRow(0))) {
            throw new ExpectationException("Expected " . count($headers->getRow(0)) . " header columns but only " . count($targetHeaders) . " found", $this->getSession());
        }

        foreach($headers->getRow(0) as $index => $column) {
            if (trim($targetHeaders[$index]->getText()) != trim($column)) {
                throw new ExpectationException("Looking for {$column} but {$targetHeaders[$index]->getText()} found", $this->getSession());
            }
        }
    }

    /**
     * @Given /^I should see "([^"]*)" in table header$/
     */
    public function assertTableHeaderContains($text)
    {
        /** @var $targetHeaders NodeElement[] */
        $targetHeaders = $this->getSession()->getPage()->findAll('css', 'table th');


        foreach($targetHeaders as $header) {
            if (trim($header->getText()) == trim($text)) {
                return ;
            }
        }

        throw new ExpectationException("Can't find {$text} in table header", $this->getSession());
    }

    /**
     * @Then /^I should see table rows:$/
     */
    public function assertTableRows(TableNode $rows)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see "([^"]*)" in table row with "([^"]*)"$/
     */
    public function assertTableRowContains($text, $search)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I should see "([^"]*)" in (\d+)(st|nd|rd)? table row$/
     */
    public function assertSpecifiedTableRowContains($text, $rowNumber)
    {
        throw new PendingException();
    }

    /**
     * @Given /^"([^"]*)" should contain "([^"]*)" in table row with "([^"]*)"$/
     */
    public function assertTableColumnForTableRowContain($column, $text, $search)
    {
        throw new PendingException();
    }

    /**
     * @Given /^"([^"]*)" should contain "([^"]*)" in (\d+)(st|nd|rd)? table row$/
     */
    public function assertTableColumnForSpecifiedTableRowContain($column, $text, $rowNumber)
    {
        throw new PendingException();
    }

    /**
     * @Given /^(\d+)(st|nd|rd)? cell should contain "([^"]*)" in table row with "([^"]*)"$/
     */
    public function assertSpecifiedTableColumnForTableRowContain($columnNumber, $text, $search)
    {
        throw new PendingException();
    }

    /**
     * @Given /^(\d+)rd cell should contain "([^"]*)" in (\d+)st table row$/
     */
    public function assertSpecifiedTableColumnForSpecifiedTableRowContain($columnNumber, $text, $rowNumber)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I follow "([^"]*)" in table row with "([^"]*)"$/
     */
    public function iFollowInTableRowWith($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I follow "([^"]*)" in (\d+)nd table row$/
     */
    public function iFollowInNdTableRow($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I check table row with "([^"]*)"$/
     */
    public function iCheckTableRowWith($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check (\d+)nd table row$/
     */
    public function iCheckNdTableRow($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check "([^"]*)" in table row with name "([^"]*)"$/
     */
    public function iCheckInTableRowWithName($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check "([^"]*)" in (\d+)rd table row$/
     */
    public function iCheckInRdTableRow($arg1, $arg2)
    {
        throw new PendingException();
    }
}
