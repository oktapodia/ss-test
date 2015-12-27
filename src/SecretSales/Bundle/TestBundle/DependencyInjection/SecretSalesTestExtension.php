<?php

namespace SecretSales\Bundle\TestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class SecretSalesTestExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $this->configureParametersFromConfigurations($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * Convert the secret_sales_test configuration in config.yml to parameters
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureParametersFromConfigurations(array $config, ContainerBuilder $container)
    {
        if (!array_key_exists('providers', $config)) {
            return;
        }

        foreach ($config['providers'] as $providerName => $providerConfigurations) {
            foreach ($providerConfigurations as $providerConfigurationKey => $providerConfigurationValue) {
                $container->setParameter('ss.'.$providerName.'.'.$providerConfigurationKey, $providerConfigurationValue);
            }
        }
    }
}
