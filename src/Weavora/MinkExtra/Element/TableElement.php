<?php

namespace Weavora\MinkExtra\Element;

use Behat\Mink\Element\NodeElement;

class TableElement extends NodeElement
{
    private $columns = null;

    private $rows = null;

    /**
     * @return NodeElement[]
     */
    public function getHeader()
    {
        return $this->findAll('css', 'th');
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        if (is_null($this->columns)) {
            $this->columns = array();
            foreach ($this->getHeader() as $column) {
                $this->columns[] = $column->getText();
            }
        }

        return $this->columns;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasColumn($name)
    {
        return in_array($name, $this->getColumns());
    }

    public function getRows()
    {
        if (is_null($this->rows)) {
            $this->rows = array();
            foreach ($this->findAll('css', 'tbody tr') as $row) {
                $rowColumns = array();
                foreach ($row->findAll('css', 'td') as $cell) {
                    $rowColumns[] = $cell->getText();
                }
                $this->rows[] = $rowColumns;
            }
        }

        return $this->rows;
    }

    public function getRow($index)
    {
        $rows = $this->getRows();

        return isset($rows[$index]) ? $rows[$index] : null;
    }

    /**
     * @param $index
     * @return NodeElement
     */
    public function getRowElement($index)
    {
        $rows = $this->findAll('css', 'tbody tr');

        return isset($rows[$index]) ? $rows[$index] : null;
    }

    public function findRowIndex($search)
    {
        foreach ($this->getRows() as $index => $row) {
            foreach ($row as $cell) {
                if (trim($cell) == trim($search)) {
                    return $index;
                }
            }
        }

        return null;
    }

    public function findRow($search)
    {
        $index = $this->findRowIndex($search);
        if (is_null($index)) {
            return null;
        }

        return $this->getRow($index);
    }

    public function getRowsByColumns($columns = array(), $named = false)
    {
        if (empty($columns)) {
            $columns = $this->getColumns();
        }

        $data = array();
        foreach ($this->getRows() as $row) {
            $namedRow = array();
            foreach ($columns as $key => $column) {
                $index = ($named ? $column : $key);
                $namedRow[$index] = $row[$this->getColumnIndex($column)];
            }
            $data[] = $namedRow;
        }

        return $data;
    }

    public function getColumnIndex($name)
    {
        return array_search($name, $this->getColumns());
    }

    public function dump()
    {
        return $this->dumpHeader() . PHP_EOL . $this->dumpRows();
    }

    public function dumpHeader()
    {
        return $this->dumpRows(array($this->getColumns()));
    }

    public function dumpRows($rows = array())
    {
        $rows = $rows ?: $this->getRows();

        $lines = array();
        foreach ($rows as $row) {
            $lines[] = '| ' . join(' | ', $row) . ' |';
        }

        return join(PHP_EOL, $lines);
    }
}
