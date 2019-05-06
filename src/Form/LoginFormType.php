<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username',)
            ->add('_password', PasswordType::class);
    }

    /**
     * This will remove formTypeName from the form
     * @return null
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
