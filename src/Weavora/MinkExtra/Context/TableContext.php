<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Node\TableNode;
use Weavora\MinkExtra\Element\TableElement;
use Behat\Behat\Exception\PendingException;
use PHPUnit_Framework_Assert as Assert;

/**
 * Table Context
 *
 * Class provide additional steps to asserts table content
 */
class TableContext extends BaseContext
{

    public function getSelector($name)
    {
        $selectors = $this->getParameter('selectors');
        Assert::assertArrayHasKey($name, $selectors);

        return $selectors[$name];
    }

    /**
     * @param string $table
     * @return TableElement
     */
    protected function findTable($table = '')
    {
        $xpath = $this->getSession()->getSelectorsHandler()->selectorToXpath('css', $this->getSelector($table));
        return new TableElement($xpath, $this->getSession());
    }

    /**
     * @Then /^I should see (?P<tableName>[\w\d\-]+) table header:$/
     */
    public function assertTableHeader($tableName, TableNode $expectedHeader)
    {
        Assert::assertEquals($expectedHeader->getRow(0), $this->findTable($tableName)->getColumns());
    }

    /**
     * @Given /^I should see "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table header$/
     */
    public function assertTableHeaderContains($text, $tableName)
    {
        Assert::assertContains($text, $this->findTable($tableName)->getColumns());
    }

    /**
     * @Then /^I should see (?P<tableName>[\w\d\-]+) table rows:$/
     */
    public function assertTableRows($tableName, TableNode $rows)
    {
        $rows = $rows->getRows();
        $columns = array_shift($rows);
        $table = $this->findTable($tableName)->getRowsByColumns($columns);

        foreach($rows as $row) {
            Assert::assertContains($row, $table);
        }
    }

    /**
     * @Then /^I should see "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<search>[^"]*)"$/
     */
    public function assertTableRowContains($text, $search, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->findRow($search);

        Assert::assertNotEmpty($row);
        Assert::assertContains($text, $row);
    }

    /**
     * @Given /^I should see "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function assertSpecifiedTableRowContains($text, $rowNumber, $tableName)
    {
        Assert::assertContains($text, $this->findTable($tableName)->getRow($rowNumber - 1));
    }

    /**
     * @Given /^"(?P<column>[^"]*)" should contain "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<search>[^"]*)"$/
     */
    public function assertTableColumnForTableRowContain($column, $text, $search, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->findRow($search);
        $columnIndex = $table->getColumnIndex($column);

        Assert::assertNotNull($columnIndex);
        Assert::assertNotNull($row);
        Assert::assertEquals($text, $row[$columnIndex]);
    }

    /**
     * @Given /^"(?P<column>[^"]*)" should contain "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function assertTableColumnForSpecifiedTableRowContain($column, $text, $rowNumber, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->getRow($rowNumber - 1);
        $columnIndex = $table->getColumnIndex($column);

        Assert::assertNotNull($columnIndex);
        Assert::assertNotNull($row);
        Assert::assertEquals($text, $row[$columnIndex]);
    }

    /**
     * @Given /^(?P<columnNumber>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<search>[^"]*)"$/
     */
    public function assertSpecifiedTableColumnForTableRowContain($columnNumber, $text, $search, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->findRow($search);

        Assert::assertNotNull($row);
        Assert::assertContains($text, $row[$columnNumber - 1]);
    }

    /**
     * @Given /^(?P<columnNumber>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function assertSpecifiedTableColumnForSpecifiedTableRowContain($columnNumber, $text, $rowNumber, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->getRow($rowNumber - 1);

        Assert::assertNotNull($row);
        Assert::assertContains($text, $row[$columnNumber - 1]);
    }

    /**
     * @Then /^I follow "(?P<link>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<search>[^"]*)"$/
     */
    public function followLinkInTableRow($link, $search, $tableName)
    {
        $table = $this->findTable($tableName);
        $rowNumber = $table->findRowIndex($search);

        Assert::assertNotNull($rowNumber);

        $row = $table->getRowElement($rowNumber);
        Assert::assertNotNull($row);

        $row->clickLink($link);
    }

    /**
     * @Given /^I follow "(?P<link>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function followLinkInSpecifiedTableRow($link, $rowNumber, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = $table->getRowElement($rowNumber - 1);
        Assert::assertNotNull($row);

        $row->clickLink($link);
    }

    /**
     * @Then /^I check (?P<tableName>[\w\d\-]+) table row with "(?P<search>[^"]*)"$/
     */
    public function iCheckTableRowWith($search, $tableName)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function iCheckNdTableRow($rowNumber, $tableName)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check "(?P<label>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with name "(?P<search>[^"]*)"$/
     */
    public function iCheckInTableRowWithName($label, $tableName, $search)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I check "(?P<label>[^"]*)" in (?P<rowNumber>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function iCheckInRdTableRow($label, $rowNumber, $tableName)
    {
        throw new PendingException();
    }
}
