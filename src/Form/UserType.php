<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserState;
use App\Entity\Role;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('username')
            ->add('email')
            ->add('mdp')
            ->add('num_tel')
            ->add('CIN')
            ->add('images',FileType::class,[
                'required'=>false,
                'mapped'=>false,
                'constraints'=>
                [new File([
                    'maxSize'=>'1024K',
                    'mimeTypes'=>[
                       'image/jpeg',
                       'image/png',
                       'image/jpg'
            ],
            'mimeTypesMessage'=> 'vous devez choisir une image valide',
        ]),
    ],
    ])
            ->add('id_role',EntityType::class,
            ['class'=>Role::class,
            'choice_label'=>'nom'])
            ->add('id_state',EntityType::class,
            ['class'=>UserState::class,
            'choice_label'=>'status'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    
}
