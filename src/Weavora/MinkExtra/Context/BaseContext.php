<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Session;

class BaseContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * Get page session
     *
     * @param string|null $name
     * @return Session
     */
    public function getSession($name = null)
    {
        return parent::getSession($name);
    }

//    public function assertStringEquals($expected, $value)
//    {
//        if (trim($expected) != trim($value)) {
//            throw new ExpectationException(sprintf("Expected %s, but %s given", $expected, $value), $this->getSession());
//        }
//    }
//
//    public function assertCount($expected, $value)
//    {
//        if (count($value) != $expected) {
//            throw new ExpectationException(sprintf("Expected %s elements, but %s given", $expected, count($value)), $this->getSession());
//        }
//    }
//
//    public function assertArrayEquals($expected, $value)
//    {
//
//    }
}
