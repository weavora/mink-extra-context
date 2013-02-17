<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Weavora\MinkExtra\Element\TableElement;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Session;
use PHPUnit_Framework_Assert as Assert;

/**
 * Table Context
 *
 * Class provide additional steps to asserts table content
 */
class TableContext extends BaseContext
{

    /**
     * @param string $table
     * @return TableElement
     */
    protected function findTable($table = '')
    {
        $xpath = $this->getSession()->getSelectorsHandler()->selectorToXpath('css', 'table');
        return new TableElement($xpath, $this->getSession());
    }

    /**
     * @Then /^I should see table header:$/
     */
    public function assertTableHeader(TableNode $expectedHeader)
    {
        Assert::assertEquals($expectedHeader->getRow(0), $this->findTable()->getColumns());
    }

    /**
     * @Given /^I should see "([^"]*)" in table header$/
     */
    public function assertTableHeaderContains($text)
    {
        Assert::assertContains($text, $this->findTable()->getColumns());
    }

    /**
     * @Then /^I should see table rows:$/
     */
    public function assertTableRows(TableNode $rows)
    {
        $rows = $rows->getRows();
        $columns = array_shift($rows);
        $table = $this->findTable()->getRowsByColumns($columns);

        foreach($rows as $row) {
            Assert::assertContains($row, $table);
        }
    }

    /**
     * @Then /^I should see "([^"]*)" in table row with "([^"]*)"$/
     */
    public function assertTableRowContains($text, $search)
    {
        $table = $this->findTable();
        $row = $table->findRow($search);

        Assert::assertNotEmpty($row);
        Assert::assertContains($text, $row);
    }

    /**
     * @Given /^I should see "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? table row$/
     */
    public function assertSpecifiedTableRowContains($text, $rowNumber)
    {
        Assert::assertContains($text, $this->findTable()->getRow($rowNumber - 1));
    }

    /**
     * @Given /^"([^"]*)" should contain "([^"]*)" in table row with "([^"]*)"$/
     */
    public function assertTableColumnForTableRowContain($column, $text, $search)
    {
        $table = $this->findTable();
        $row = $table->findRow($search);
        $columnIndex = $table->getColumnIndex($column);

        Assert::assertNotNull($columnIndex);
        Assert::assertNotNull($row);
        Assert::assertEquals($text, $row[$columnIndex]);
    }

    /**
     * @Given /^"(?P<column>[^"]*)" should contain "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? table row$/
     */
    public function assertTableColumnForSpecifiedTableRowContain($column, $text, $rowNumber)
    {
        $table = $this->findTable();
        $row = $table->getRow($rowNumber - 1);
        $columnIndex = $table->getColumnIndex($column);

        Assert::assertNotNull($columnIndex);
        Assert::assertNotNull($row);
        Assert::assertEquals($text, $row[$columnIndex]);
    }

    /**
     * @Given /^(?P<columnNumber>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in table row with "(?P<search>[^"]*)"$/
     */
    public function assertSpecifiedTableColumnForTableRowContain($columnNumber, $text, $search)
    {
        $table = $this->findTable();
        $row = $table->findRow($search);

        Assert::assertNotNull($row);
        Assert::assertContains($text, $row[$columnNumber - 1]);
    }

    /**
     * @Given /^(?P<columnNumber>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? table row$/
     */
    public function assertSpecifiedTableColumnForSpecifiedTableRowContain($columnNumber, $text, $rowNumber)
    {
        $table = $this->findTable();
        $row = $table->getRow($rowNumber - 1);

        Assert::assertNotNull($row);
        Assert::assertContains($text, $row[$columnNumber - 1]);
    }

    /**
     * @Then /^I follow "([^"]*)" in table row with "([^"]*)"$/
     */
    public function followLinkInTableRow($link, $search)
    {
        $table = $this->findTable();
        $rowNumber = $table->findRowIndex($search);

        Assert::assertNotNull($rowNumber);

        $row = $table->getRowElement($rowNumber);
        Assert::assertNotNull($row);

        $row->clickLink($link);
    }

    /**
     * @Given /^I follow "(?P<link>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? table row$/
     */
    public function followLinkInSpecifiedTableRow($link, $rowNumber)
    {
        $table = $this->findTable();
        $row = $table->getRowElement($rowNumber - 1);
        Assert::assertNotNull($row);

        $row->clickLink($link);
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
