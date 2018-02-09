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

namespace Forci\Bundle\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Forci\Bundle\Locale\Locale\Locale;
use Forci\Bundle\Locale\Manager\LocaleManager;

class LocaleChoiceType extends AbstractType {

    /** @var LocaleManager */
    protected $manager;

    public function __construct(LocaleManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $locales = $this->manager->getLocales();
        $choices = [];
        /** @var Locale $locale */
        foreach ($locales as $locale) {
            if ($locale->getIsEnabled()) {
                $choices[$locale->getName()] = $locale->getLocale();
            }
        }
        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }

    public function getParent() {
        return ChoiceType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {
        return 'forci_locale_choice';
    }
}
