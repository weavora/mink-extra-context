<?php

namespace Weavora\MinkExtra\Context;

/**
 * Page Context
 *
 * Class provide hooks to handle complete page loading for sessions with javascript support (e.g. selenium2)
 */
class PageContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * @AfterStep @javascript
     */
    public function waitForPage($event)
    {
        $text = $event->getStep()->getText();
        if (preg_match('/(follow|press|click|submit|go to)/i', $text)) {
            $this->getSession()->wait(5000,
                "document.readyState == 'complete'"
            );
        }
    }
}
