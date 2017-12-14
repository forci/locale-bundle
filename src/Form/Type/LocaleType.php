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

use Forci\Bundle\LocaleBundle\Locale\Locale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class LocaleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('locale', TextType::class, [
                'label' => 'Locale',
                'attr' => [
                    'placeholder' => 'Locale',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'message' => 'Invalid locale name',
                        'pattern' => '/^[a-z0-9@_\\.\\-]*$/i',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Name',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label' => 'Is Enabled',
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('currency', TextType::class, [
                'label' => 'Currency',
                'attr' => [
                    'placeholder' => 'Currency',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function getBlockPrefix() {
        return 'forci_locale';
    }

    public function setDefaultOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Locale::class,
        ]);
    }
}
