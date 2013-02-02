<?php

namespace Weavora\MinkExtra\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;


class SubContextPass implements CompilerPassInterface
{
    /**
     * Loads kernel file.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('mink-extra.context.initializer')) {
            return;
        }

        $minkExtraInitializer = $container->getDefinition('mink-extra.context.initializer');
        $minkExtraContexts = $container->findTaggedServiceIds('mink-extra.context');

        foreach ($minkExtraContexts as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $minkExtraInitializer->addMethodCall(
                    'addContext',
                    array($attributes['alias'], new Reference($id))
                );
            }
        }
    }
}
