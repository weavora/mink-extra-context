<?php

namespace Weavora\MinkExtra\Context;

/**
 * Page Area Context
 *
 * Class help to separate page into different area (e.g. menu, content and etc)
 */
class PageAreaContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    private $areas = array();

    public function __construct($areas = array())
    {
        $this->setAreas($areas);
    }

    /**
     * Get block CSS-selector
     *
     * @param string $block Block name
     * @return string CSS-selector
     */
    private function getAreaSelector($area)
    {
        $area = trim(strtolower($area));

        if (!array_key_exists($area, $this->areas)) {
            throw new \Behat\Behat\Exception\PendingException("{$area} is not defined in page context");
        }

        return $this->areas[$area];
    }

    /**
     * @Then /^I should see "([^"]*)" in (.*?) area$/
     */
    public function iShouldSeeIn($text, $area)
    {
        $this->assertSession()->elementContains('css', $this->getAreaSelector($area), $this->fixStepArgument($text));
    }

    /**
     * @Then /^I shouldn't see "([^"]*)" in (.*?) area$/
     */
    public function iShouldNotSeeIn($text, $area)
    {
        $this->assertSession()->elementNotContains('css', $this->getAreaSelector($area), $this->fixStepArgument($text));
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

    public function setAreas($areas)
    {
        $this->areas = $areas;
    }

    public function getAreas()
    {
        return $this->areas;
    }
}
