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

namespace Forci\Bundle\Locale\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Forci\Bundle\Locale\Manager\LocaleManager;

class DisabledLocaleRedirectSubscriber implements EventSubscriberInterface {

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var LocaleManager
     */
    protected $manager;

    /**
     * @var bool
     */
    protected $isDebug;

    protected $usePreferredLocale = false;

    public function __construct(Router $router, LocaleManager $manager, $isDebug, $config) {
        $this->router = $router;
        $this->manager = $manager;
        $this->isDebug = $isDebug;
        if (isset($config['use_preferred_locale'])) {
            $this->usePreferredLocale = $config['use_preferred_locale'];
        }
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest',
                0,
            ],
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        // don't redirect in dev
        if ($this->isDebug) {
            return;
        }

        $request = $event->getRequest();
        $locale = $request->attributes->get('_locale');

        // nothing to do here, not a URL that has to do with _locale route param
        if (null === $locale) {
            return;
        }

        // locale exists and is enabled, nothing to do here - return;
        if ($this->manager->isLocaleEnabled($locale)) {
            return;
        }

        $route = $request->attributes->get('_route');

        // no route found, nothing to do here - return; and let the 404 handler do its job
        if (null === $route) {
            return;
        }

        $toLocale = $this->manager->getDefaultLocale();

        if ($this->usePreferredLocale && $this->manager->getPreferredLocale() != $locale) {
            $toLocale = $this->manager->getPreferredLocale();
        }

        $params = array_replace_recursive($request->attributes->get('_route_params', []), [
            '_locale' => $toLocale,
        ]);

        // generate a url for the same route with the same params, but with the default locale
        $url = $this->router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL);

        // append query string if any
        $qs = $request->getQueryString();
        if ($qs) {
            $url = $url.'?'.$qs;
        }

        $response = new RedirectResponse($url, Response::HTTP_FOUND);

        $event->setResponse($response);
    }

}
