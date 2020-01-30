<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CurrencyProviderPass implements CompilerPassInterface
{
    const ID = 'app.service.chain_currency_provider';
    const TAG = 'app.currency_provider';

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::ID)) {
            return;
        }
        $definition = $container->findDefinition(self::ID);

        $taggedServices = $container->findTaggedServiceIds(self::TAG);
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [$tags[0]['alias'], new Reference($id)]);
        }
    }
}