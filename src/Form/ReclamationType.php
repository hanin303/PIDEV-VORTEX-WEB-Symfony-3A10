<?php
namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('message_rec', TextareaType::class, [
                'label' => 'Text reclamation',
                'attr' => [
                    'rows' => 15, // Set the number of visible rows to 5
                    'style' => 'font-size: 16px;', // Optional: Set a custom font size
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ message ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('objet', TextareaType::class,[
                'label' => 'objet',
                'attr' => [
                    'style' => 'font-size: 16px;', // Optional: Set a custom font size
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ message ne peut pas être vide',
                    ]),
                ]
             ])
            ->add('statut')
            ->add('date_rec', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd', // Spécifier le format de la date
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ date ne peut pas être vide',
                    ]),
                    new Date([
                        'message' => 'La date saisie n\'est pas valide',
                    ]),
                ],
            ])
            ->add('Reclamer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}

