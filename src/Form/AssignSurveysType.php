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
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'name',
                'query_builder' => fn($repo) => $repo->createQueryBuilder('s')
                    ->where('s.deletedAt IS NULL')
                    ->orderBy('s.name', 'ASC'),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panelist::class,
        ]);
    }
}
