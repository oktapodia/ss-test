<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\DependencyInjection\CompilerPass;

use SecretSales\Bundle\TestBundle\Provider\ProviderContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Automatically add providers with tagged service
 *
 * Class HydrateProviderContainerCompilerPass
 */
class HydrateProviderContainerCompilerPass implements CompilerPassInterface
{
    const METHOD_CALLED       = 'addProvider';
    const PROVIDER_TAG        = 'ss.provider';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(ProviderContainer::PROVIDER_CONTAINER)) {
            return;
        }

        $definition = $container->findDefinition(ProviderContainer::PROVIDER_CONTAINER);

        foreach ($container->findTaggedServiceIds(self::PROVIDER_TAG) as $id => $attributes) {
            $definition->addMethodCall(
                self::METHOD_CALLED,
                array(new Reference($id))
            );
        }
    }
}
