<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Enum\TransactionFormTypeMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*$builder
            ->add('reference')
            ->add('authorization')
            ->add('submitterId')
            ->add('amount')
            ->add('origin')
            ->add('target')
        ;*/

        $builder->add(
            'amount',
            MoneyType::class,
            [
                'currency'    => 'EUR',
                'divisor'     => 100,
                'constraints' => [
                    new Positive(),
                ],
            ]
        );

        if ($options['usage_context'] === TransactionFormTypeMode::TRANSFER()) {
            $builder->add('target');
            $builder->add('reference');
        }

        if ($options['usage_context'] === TransactionFormTypeMode::SEPA()) {
            $builder
                ->add(
                    'origin',
                    null,
                    [
                        'constraints' => [
                            new NotNull()
                        ]
                    ]
                )
                ->add(
                    'reference',
                    null,
                    [
                        'constraints' => [
                            new NotNull()
                        ]
                    ]
                )
                ->add(
                    'authorization',
                    null,
                    [
                        'constraints' => [
                            new NotNull()
                        ]
                    ]
                )
                ->add(
                    'submitterId',
                    null,
                    [
                        'constraints' => [
                            new NotNull()
                        ]
                    ]
                )
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class'    => Transaction::class,
                'usage_context' => TransactionFormTypeMode::DEPOSIT(),
            ]
        );
    }
}
