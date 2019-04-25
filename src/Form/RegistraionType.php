<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistraionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')),array(
                'placeholder'=> 'Votre Nom'))

            ->add('prenom',TextType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')))

            ->add('telephone',NumberType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')))

            ->add('adresse',TextareaType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')))

            ->add('email',EmailType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')))

            ->add('password',PasswordType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row')))

            ->add('confirm_password',PasswordType::class,array('attr'=>
            array('class'=>'form-group col-sm-5 row'),
            'label'=>'Confirmation du mot de passe'))

            ->add('save',SubmitType::class,array(
                'label' =>'Crée mon compte',
                'attr'=> array('class'=>'btn btn-success btn-lg btn-login text-uppercase font-weight-bold')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}