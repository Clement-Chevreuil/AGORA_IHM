<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserRoleAdminType extends AbstractType
{
    private $token;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user  = $this->token->getToken()->getUser();

        if((in_array("ROLE_ADMIN", $user->getRoles()) && !in_array("ROLE_ADMIN", $options['data']->getRoles())) || (in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && !in_array("ROLE_SUPER_ADMIN",$options['data']->getRoles())) )
        {
            $builder->add('roles', ChoiceType::class, [
                'choices'  => [
                    // 'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true
            ]);
        }
 

        if((in_array("ROLE_ADMIN", $user->getRoles()) && !in_array("ROLE_ADMIN", $options['data']->getRoles())) || (in_array("ROLE_SUPER_ADMIN", $user->getRoles()) && !in_array("ROLE_SUPER_ADMIN",$options['data']->getRoles())) )
        {
             $builder->add('blocked', CheckboxType::class, [
            'label'    => 'Bloqué ?',
            'required' => false,
            ]); 
        }
        ;
    }

    public function __construct(TokenStorageInterface $token )
    {
        $this->token = $token; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
