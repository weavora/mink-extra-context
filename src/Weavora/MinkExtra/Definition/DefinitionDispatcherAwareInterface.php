<?php

namespace Weavora\MinkExtra\Definition;

interface DefinitionDispatcherAwareInterface
{
    public function setDefinitionDispatcher(\Behat\Behat\Definition\DefinitionDispatcher $dispatcher);
}
