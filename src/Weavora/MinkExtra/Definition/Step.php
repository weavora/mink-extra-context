<?php

namespace Weavora\MinkExtra\Definition;

use Behat\Gherkin\Node\StepNode;

class Step implements \Behat\Behat\Context\Step\SubstepInterface
{
    private $node;

    public function __construct(StepNode $node)
    {
        $this->node = $node;
    }

    /**
     * Returns substep node.
     *
     * @return StepNode
     */
    public function getStepNode()
    {
        return $this->node;
    }
}
