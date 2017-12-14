<?php

/*
 * This file is part of the ForciLocaleBundle package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Forci\Bundle\LocaleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Forci\Bundle\LocaleBundle\Locale\Locale;
use Forci\Bundle\LocaleBundle\Manager\LocaleManager;

class LocaleChoiceType extends AbstractType {

    /** @var LocaleManager */
    protected $manager;

    public function __construct(LocaleManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver) {
        $locales = $this->manager->getLocales();
        $choices = [];
        /** @var Locale $locale */
        foreach ($locales as $locale) {
            if ($locale->getIsEnabled()) {
                $choices[$locale->getLocale()] = $locale->getName();
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
