<?php

namespace App\Form;

use App\Entity\MoyenTransport;
use App\Entity\Station;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('long_alt')
            ->add('id_moy', EntityType::class, [
                'class' => MoyenTransport::class,
                'choice_label' => 'id',
                'multiple' => true, // set to false if you want a single select dropdown
                'expanded' => false, 
            ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Station::class,
        ]);
    }
}
