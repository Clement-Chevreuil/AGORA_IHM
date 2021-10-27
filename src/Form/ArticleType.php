<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Name',
                'row_attr' => [
                    'class' => 'input-group',
                ],
            ])
            
            // ->add('description', TextareaType::class,[
            //     'row_attr' => [
            //         'class' => 'text_position form-control mt-3 mb-3 ',
            //         'style' => 'height: 300px; ',
            //     ],
                
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a description',
            //         ]),
            //         new Length([
            //             'min' => 100,
            //             'minMessage' => 'Your description should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //         ]),
            //     ],
            // ])
            ->add('picture', FileType::class, [
                'label' => 'Picture',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'row_attr' => [
                    'class' => 'input-group mt-3 mb-3',
                ],

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg', 
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid picture',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
