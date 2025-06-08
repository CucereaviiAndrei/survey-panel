<?php

namespace App\Form;

use App\Entity\Panelist;
use App\Entity\Survey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignSurveysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surveys', EntityType::class, [
                'class' => Survey::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select', 'size' => 6],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panelist::class,
        ]);
    }
}
