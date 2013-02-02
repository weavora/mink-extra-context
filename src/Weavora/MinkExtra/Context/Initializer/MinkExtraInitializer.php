<?php

namespace Weavora\MinkExtra\Context\Initializer;

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Initializer\InitializerInterface;
use Weavora\MinkExtra\Context\MinkExtraContext;

class MinkExtraInitializer implements InitializerInterface
{
    /**
     * @var BehatContext[]
     */
    private $contexts = array();

    private $parameters = array();

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function supports(ContextInterface $context)
    {
        return ($context instanceof MinkExtraContext);
    }

    /**
     * @param MinkExtraContext $context
     */
    public function initialize(ContextInterface $context)
    {
        foreach($this->getContexts() as $alias => $subContext) {
            if (isset($this->parameters[$alias]) && $this->parameters[$alias]) {
                $context->useContext($alias, $subContext);
            }
        }
    }

    public function getContexts()
    {
        return $this->contexts;
    }

    public function addContext($alias, BehatContext $context)
    {
        $this->contexts[$alias] = $context;
    }
}
