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

        if (isset($selectors[$name])) {
            return $selectors[$name];
        }

        // if no such table selector defined let's try to find table by class
        return "table.{$name}";
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
        $table = $this->findTable($tableName);
        Assert::assertEquals($expectedHeader->getRow(0), $table->getColumns(), "Table header looks different: " . $table->dumpHeader());
    }

    /**
     * @Given /^I should see "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table header$/
     */
    public function assertTableHeaderContains($text, $tableName)
    {
        $table = $this->findTable($tableName);
        Assert::assertContains($text, $table->getColumns(), "Couldn't find {$text} in table: " . PHP_EOL . $table->dump());
    }

    /**
     * @Then /^I should see (?P<tableName>[\w\d\-]+) table rows:$/
     */
    public function assertTableRows($tableName, TableNode $rows)
    {
        $rows = $rows->getRows();
        $columns = array_shift($rows);
        $table = $this->findTable($tableName);
        $selectedRows = $table->getRowsByColumns($columns);

        foreach($rows as $index => $row) {
            Assert::assertContains($row, $selectedRows, "Couldn't find row #" . ($index + 1) . " in table: " . PHP_EOL . $table->dumpRows($selectedRows));
        }
    }

    /**
     * @Then /^I should see "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<row>[^"]*)"$/
     * @Then /^I should see "(?P<text>[^"]*)" in (?P<row>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function assertTableRowContains($text, $row, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = is_numeric($row) ? $table->getRow($row - 1) : $table->findRow($row);

        Assert::assertNotEmpty($row, "Couldn't find row ". is_null($row) ? '' : implode($row, ' | ') ." in table: " . PHP_EOL . $table->dump());
        Assert::assertContains($text, $row, "Couldn't find {$text} in row " . $table->dumpRows(array($row)));
    }

    /**
     * @Then /^"(?P<column>[^"]*)" should contain "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<row>[^"]*)"$/
     * @Then /^"(?P<column>[^"]*)" should contain "(?P<text>[^"]*)" in (?P<row>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     * @Then /^(?P<column>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<row>[^"]*)"$/
     * @Then /^(?P<column>\d+)(st|nd|rd|th)? cell should contain "(?P<text>[^"]*)" in (?P<row>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function assertTableColumnForTableRowContain($column, $text, $row, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = is_numeric($row) ? $table->getRow($row - 1) : $table->findRow($row);
        $column = is_numeric($column) ? $column - 1 : $table->getColumnIndex($column);

        Assert::assertNotNull($row, "Couldn't find row ". is_null($row) ? '' : implode($row, ' | ')  ." in table: " . PHP_EOL . $table->dump());
        Assert::assertNotNull($column, "Couldn't find column {$column} in table header: " . PHP_EOL . $table->dumpHeader());
        Assert::assertEquals($text, $row[$column], "Couldn't find {$text} in column with '{$row[$column]}'");
    }

    /**
     * @Then /^I follow "(?P<link>[^"]*)" in (?P<tableName>[\w\d\-]+) table row with "(?P<row>[^"]*)"$/
     * @Then /^I follow "(?P<link>[^"]*)" in (?P<row>\d+)(st|nd|rd|th)? (?P<tableName>[\w\d\-]+) table row$/
     */
    public function followLinkInTableRow($link, $row, $tableName)
    {
        $table = $this->findTable($tableName);
        $row = is_numeric($row) ? $row - 1 : $table->findRowIndex($row);

        Assert::assertNotNull($row, "Couldn't find row {$row} in table: " . PHP_EOL . $table->dump());

        $row = $table->getRowElement($row);
        Assert::assertNotNull($row);

        $row->clickLink($link);
    }

    /**
     * @Then /^print (?P<tableName>[\w\d\-]+) table$/
     */
    public function printTable($tableName)
    {
        $table = $this->findTable($tableName);
        echo $table->dump(). PHP_EOL;
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
