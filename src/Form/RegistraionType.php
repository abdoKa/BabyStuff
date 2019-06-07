<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistraionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => '3'
                ]
            ])

            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => '3'
                ]
            ])


            ->add('telephone', TelType::class, [
                'required' => true,
                'attr' => [
                    'pattern' => '(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}'
                ]
            ])


            ->add('adresse', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => '10'
                ]
            ])


            ->add('email', EmailType::class, [
                'required' => true
            ])


            ->add('password', PasswordType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => '8'
                ]
            ])


            ->add('confirm_password', PasswordType::class, [
                'required' => true,
                'attr' => [
                    'minlength' => '8'
                ]
            ])


            ->add('save', SubmitType::class, array(
                'label' => 'Crée mon compte',
                'attr' => array('class' => 'btn-success btn-lg btn-login text-uppercase font-weight-bold')
            ));
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
