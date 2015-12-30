<?php

namespace SecretSales\Bundle\TestBundle;

use SecretSales\Bundle\TestBundle\DependencyInjection\CompilerPass\HydrateProviderContainerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SecretSalesTestBundle.
 */
class SecretSalesTestBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new HydrateProviderContainerCompilerPass());
        parent::build($container);
    }
}
