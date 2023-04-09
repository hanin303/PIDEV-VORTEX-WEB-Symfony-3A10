<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Iteneraire;
use App\Entity\MoyenTransport;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reservation')
            ->add('heure_depart')
            ->add('heure_arrive')
            ->add('status')
            ->add('type_ticket')
            ->add('id_client' , EntityType::class,
            ['class'=>User::class,
            'choice_label'=>'nom'])
            ->add('id_moy',EntityType::class,
            ['class'=>MoyenTransport::class,
            'choice_label'=>'type_vehicule'])
            ->add('id_it', EntityType::class,
            ['class'=>Iteneraire::class,
            'choice_label'=> function($iteneraire) {
                return $iteneraire->getPtsDepart() . ' - ' . $iteneraire->getPtsArrive();
            }])
            ->add('id_ticket',EntityType::class,
            ['class'=>Ticket::class,
            'choice_label'=>'id'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
