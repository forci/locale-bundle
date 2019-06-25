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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ForciLocaleExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container) {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $bag = $container->getParameterBag();

        $bag->set('forci_locale.config', $config);

        $locales = $config['locales'];
        $localesSimple = array_keys($locales);

        $bag->set('forci_locale.locales', $locales);
        $bag->set('forci_locale.locales_simple', $localesSimple);

        $loader->load('services/managers.xml');
        $loader->load('services/forms.xml');

        $bag->set('forci_locale.cookie', $config['cookie']);
        
        if ($config['cookie_listener']['enabled']) {
            $loader->load('services/subscriber/cookie.xml');
        }

        if (isset($config['disabled_locale_redirect_listener']) && $config['disabled_locale_redirect_listener']['enabled']) {
            $bag->set('forci_locale.disabled_locale_redirect_listener', $config['disabled_locale_redirect_listener']);
            $loader->load('services/subscriber/disabled_locale_redirect.xml');
        }

        $bag->set('forci_locale.locales_enabled.routing', implode('|', $localesSimple));
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container) {
        return new Configuration();
    }

    public function getXsdValidationBasePath() {
        return __DIR__.'/../Resources/config/';
    }

    public function getNamespace() {
        return 'http://www.example.com/symfony/schema/';
    }
}
