<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrdersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUtilisateur')
            ->add('PrenomUtilisateur')
            ->add('email')
            ->add('telephone')
            ->add('adresse')
            ->add('commentaire')
            ->add('save',SubmitType::class,array(
                'label' =>'Commander Maintenant',
                'attr'=> array('class'=>'btn btn-success btn-lg ')))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
 
}
