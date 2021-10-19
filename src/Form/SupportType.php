<?php

namespace App\Form;

use App\Entity\Support;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;

class SupportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Title',
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ])
            
            ->add('information', TextareaType::class,[
                'label' => 'Informations :',
                'row_attr' => [
                    'class' => 'form-control mt-3 mb-3',
                    'style' => 'height: 400px;',
                ],
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a description',
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Your description should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }
}
