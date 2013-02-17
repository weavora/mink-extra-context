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
        $builder
            ->children()
                ->arrayNode('form')
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
//                        ->arrayNode('selectors')
//                            ->prototype('scalar')->end()
//                        ->end()
                    ->end()
                ->end()
                ->arrayNode('table')
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->arrayNode('selectors')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('page_area')
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->arrayNode('selectors')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('page')
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
//                        ->arrayNode('selectors')
//                            ->prototype('scalar')->end()
//                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

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