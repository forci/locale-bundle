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

namespace Forci\Bundle\Locale\Locale;

class Locale {

    protected $locale;

    protected $name;

    protected $isEnabled;

    protected $currency;

    /**
     * @param $locale
     * @param $name
     * @param $isEnabled
     * @param $currency
     */
    public function __construct($locale, $name, $isEnabled, $currency) {
        $this->locale = $locale;
        $this->name = $name;
        $this->isEnabled = $isEnabled;
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function getIsEnabled() {
        return $this->isEnabled;
    }

    /**
     * @param mixed $isEnabled
     */
    public function setIsEnabled($isEnabled) {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return mixed
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }
}
