<?php

namespace Weavora\MinkExtra\Context;

use PHPUnit_Framework_Assert as Assert;

/**
 * Page Area Context
 *
 * Class help to separate page into different area (e.g. menu, content and etc)
 */
class PageAreaContext extends BaseContext
{

    public function getSelector($name)
    {
        $selectors = $this->getParameter('selectors');

        if (isset($selectors[$name])) {
            return $selectors[$name];
        }

        // if no such area defined let's try to it by class
        return ".{$name}";
    }

    /**
     * @Then /^I should see "(?P<text>[^"]*)" in (?P<area>.*?) area$/
     */
    public function assertAreaContains($text, $area)
    {
        $this->assertSession()->elementContains('css', $this->getSelector($area), $this->fixStepArgument($text));
    }

    /**
     * @Then /^I should not see "(?P<text>[^"]*)" in (?P<area>.*?) area$/
     */
    public function assertAreaNotContains($text, $area)
    {
        $this->assertSession()->elementNotContains('css', $this->getSelector($area), $this->fixStepArgument($text));
    }


    /**
     * @Then /^I follow "(?P<link>[^"]*)" in (?P<area>.*?) area$/
     */
    public function followLink($link, $area)
    {
        $this->getSession()->getPage()->find('css', $this->getSelector($area))->clickLink($link);
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
