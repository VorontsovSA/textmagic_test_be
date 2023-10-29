<?php

// src/Form/Type/TaskType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionForm extends AbstractType
{
    public const LABEL = 'label';
    public const CHOICES = 'choices';
    public const FIELD_ANSWER = 'answer';

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            static::LABEL,
            static::CHOICES,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(static::FIELD_ANSWER, ChoiceType::class, [
                'label' => $options[static::LABEL],
                'choices' => $options[static::CHOICES],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('Submit', SubmitType::class)
        ;
    }
}
