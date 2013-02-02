<?php

namespace Weavora\MinkExtra;

use Symfony\Component\Config\FileLocator;
use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Extension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        // initialize services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Resources/config'));
        $loader->load('services.yml');

        // pass parameters to MinkExtraInitializer
        $container->setParameter('mink-extra.parameters', $config);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
        $builder->
            children()->
                booleanNode('form')->defaultTrue()->end()->
                booleanNode('table')->defaultTrue()->end()->
                booleanNode('page')->defaultTrue()->end()->
                booleanNode('page_area')->defaultTrue()->end()->
            end()->
        end();

    }

    /**
     * {@inheritDoc}
     */
    public function getCompilerPasses()
    {
        return array(
            new Compiler\SubContextPass()
        );
    }
}