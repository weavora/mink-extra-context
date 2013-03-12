<?php

namespace Weavora\MinkExtra\Definition;

use Behat\Gherkin\Node\ScenarioNode;
use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\BehaviorException;

use Behat\Gherkin\Node\StepNode;

class LazyDefinition implements \Behat\Behat\Definition\DefinitionInterface
{

    /**
     * @var ScenarioNode
     */
    private $scenario;

    /**
     * @var string
     */
    private $regexp;

    /**
     * @var string
     */
    private $matchedText;

    /**
     * @var array
     */
    private $values = array();

    public function __construct(ScenarioNode $scenario)
    {
        $this->scenario = $scenario;

    }

    /**
     * Returns definition type (Given|When|Then).
     *
     * @return string
     */
    public function getType()
    {
        return 'When';
    }

    /**
     * Saves matched step text to definition.
     *
     * @param string $text
     */
    public function setMatchedText($text)
    {
        $this->matchedText = $text;
    }

    /**
     * Returns matched step text.
     *
     * @return string
     */
    public function getMatchedText()
    {
        return $this->matchedText;
    }

    /**
     * Sets step parameters for step run.
     *
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * Returns step parameters for step run.
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    public function getRegex()
    {
        $regexp = "/^" . $this->scenario->getTitle() . "$/is";
        $regexp = preg_replace("/(<.*?>)/is", "(?P$1.*?)", $regexp);
        return $regexp;
    }

    /**
     * Runs definition callback.
     *
     * @param ContextInterface $context
     *
     * @return mixed
     *
     * @throws BehaviorException
     */
    public function run(ContextInterface $context)
    {

        preg_match($this->getRegex(), $this->getMatchedText(), $matches);

        $replacements = array();
        foreach($matches as $key => $value) {
            if (!is_numeric($key)) {
                $replacements["<{$key}>"] = $value;
            }
        }

        $steps = array();

        foreach($this->scenario->getSteps() as $stepOutline) {
            /** @var $step StepNode */
            $step = clone $stepOutline;
            $step->setText(strtr($step->getText(), $replacements));
            $steps[] = new Step($step);
        }

        return $steps;
    }

    public function callback()
    {

    }

    /**
     * Returns callback reflection.
     *
     * @return \ReflectionFunction
     */
    public function getCallbackReflection()
    {
        return new \ReflectionMethod($this, 'callback');
    }


    public function getPath()
    {
        return get_class($this);
    }

}
