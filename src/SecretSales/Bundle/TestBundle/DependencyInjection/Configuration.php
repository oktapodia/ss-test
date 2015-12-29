<?php

namespace SecretSales\Bundle\TestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('secret_sales_test');
        $rootNode
            ->children()
                ->arrayNode('providers')
                    ->append($this->twitterProviderTreeBuilder())
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }

    /**
     * @return ArrayNodeDefinition
     */
    protected function twitterProviderTreeBuilder()
    {
        $builder = new TreeBuilder();
        $node    = $builder->root('twitter');
        $node
            ->children()
                ->scalarNode('consumer_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('consumer_secret')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('access_token')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('access_token_secret')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $node;
    }
}
