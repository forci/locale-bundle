<?php

/*
 * This file is part of the ForciLocaleBundle package.
 *
 * Copyright (c) Forci Web Consulting Ltd.
 *
 * Author Martin Kirilov <martin@forci.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\Locale\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('forci_locale');

        $rootNode
            ->children()
                ->arrayNode('locales')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('enabled')->end()
                            ->scalarNode('currency')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cookie_listener')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('name')
                            ->defaultValue('locale')
                        ->end()
                        ->integerNode('duration')
                            ->defaultValue(60 * 60 * 24 * 365)
                        ->end()
                        ->scalarNode('path')
                            ->defaultValue('/')
                        ->end()
                        ->scalarNode('host')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('disabled_locale_redirect_listener')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('use_preferred_locale')
                            ->defaultTrue()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        // ... add node definitions to the root of the tree

        return $treeBuilder;
    }
}
