<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {        

        $builder
        ->add('nom')
        ->add('prenom')
        ->add('username')
        ->add('email')
        ->add('password')
        
    
        ->add('num_tel')
        ->add('CIN')
        ->add('images',FileType::class,[
            'required'=>false,
            'mapped'=>false,
            'attr' => ['accept' => 'image/jpeg, image/png ,image/jpg'],
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

    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

}
