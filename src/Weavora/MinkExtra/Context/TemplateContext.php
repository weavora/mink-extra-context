<?php

namespace Weavora\MinkExtra\Context;

use Behat\Gherkin\Parser;

use Behat\Behat\Definition\DefinitionDispatcher;

/**
 * Template context
 */
class TemplateContext extends BaseContext implements \Weavora\MinkExtra\Definition\DefinitionDispatcherAwareInterface
{

    protected $initialized = false;

    /**
     * @var DefinitionDispatcher
     */
    protected $definitionDispatcher = null;

    public function initialize()
    {
        if ($this->initialized) {
            return true;
        }

        $keywords = new \Behat\Gherkin\Keywords\ArrayKeywords(array(
             'en' => array(
                 'feature'          => 'Feature',
                 'background'       => 'Background',
                 'scenario'         => 'Scenario',
                 'scenario_outline' => 'Scenario Outline|Scenario Template',
                 'examples'         => 'Examples|Scenarios',
                 'given'            => 'Given',
                 'when'             => 'When',
                 'then'             => 'Then',
                 'and'              => 'And',
                 'but'              => 'But'
             ))
        );
        $keywords->setLanguage('en');

        $lexer = new \Behat\Gherkin\Lexer($keywords);
        $parser = new Parser($lexer);

        foreach ($this->getParameter('templates') as $template) {
            foreach (glob($template) as $file) {
                /** @var $feature \Behat\Gherkin\Node\FeatureNode */
                $feature = $parser->parse(file_get_contents($file));

                /** @var $scenario \Behat\Gherkin\Node\ScenarioNode */
                foreach ($feature->getScenarios() as $scenario) {
                    $this->definitionDispatcher->addDefinition(new \Weavora\MinkExtra\Definition\LazyDefinition($scenario));
                }
            }
        }

        $this->initialized = true;

        return true;
    }

    public function setDefinitionDispatcher(\Behat\Behat\Definition\DefinitionDispatcher $dispatcher)
    {
        $this->definitionDispatcher = $dispatcher;
    }
}
