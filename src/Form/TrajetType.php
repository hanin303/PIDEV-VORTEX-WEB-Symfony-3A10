<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\Iteneraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temps_parcours')
            ->add('pts_depart')
            ->add('pts_arrive')
            ->add('id_it',EntityType::class,
            ['class'=>Iteneraire::class,
            'choice_label'=>'id'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
