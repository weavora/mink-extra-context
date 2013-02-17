<?php

namespace Weavora\MinkExtra\Context\Initializer;

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Initializer\InitializerInterface;
use Weavora\MinkExtra\Context\MinkExtraContext;
use Weavora\MinkExtra\Context\BaseContext;

class MinkExtraInitializer implements InitializerInterface
{
    /**
     * @var BaseContext[]
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
            if (isset($this->parameters[$alias]) && $this->parameters[$alias]['enabled']) {
                $subContext->setParameters($this->parameters[$alias]);
                $context->useContext($alias, $subContext);
            }
        }
    }

    /**
     * @return array|\Weavora\MinkExtra\Context\BaseContext[]
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    public function addContext($alias, BaseContext $context)
    {
        $this->contexts[$alias] = $context;
    }
}
