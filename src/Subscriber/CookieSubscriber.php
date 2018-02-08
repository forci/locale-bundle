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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CookieSubscriber implements EventSubscriberInterface {

    protected $name;

    protected $duration;

    protected $path;

    public function __construct($config) {
        $this->name = $config['name'];
        $this->duration = $config['duration'];
        $this->path = $config['path'];
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::RESPONSE => [
                'setLocale',
                -255,
            ],
        ];
    }

    public function setLocale(FilterResponseEvent $event) {
        $request = $event->getRequest();
        $localeCookie = $request->cookies->get($this->name);
        $currentLocale = $request->getLocale();

        if ($localeCookie == $currentLocale) {
            return;
        }

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->setCookie(new Cookie($this->name, $currentLocale, time() + $this->duration, $this->path));
    }
}
