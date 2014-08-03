<?php

namespace Weavora\MinkExtra\Context;

use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Session;

class BaseContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    private $parameters = array();

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter($name)
    {
        return $this->parameters[$name];
    }

    /**
     * Get page session
     *
     * @param  string|null $name
     * @return Session
     */
    public function getSession($name = null)
    {
        return parent::getSession($name);
    }

    public function initialize()
    {

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
