<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Categorie;
use App\Entity\Fourniseur;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referance',TextType::class)

            ->add('nom',TextType::class)

                ->add('categorie',EntityType::class,[
                           'class'=> Categorie::class,
                           'choice_label'=> 'nom',
                           'placeholder' => 'Choisir un Catégorie',
                           'attr'=>array('class'=>' dropdown-toggle form-control require')
                           ])

                ->add('fourniseur',EntityType::class,[
                    'class'=> Fourniseur::class,
                    'choice_label'=> 'nom',
                    'placeholder' => 'Choisir un Fournisseur',
                    'attr'=>array('class'=>' dropdown-toggle form-control require')
                    ])

            ->add('description',TextareaType::class)

            ->add('image', FileType::class,[
                 'data_class' => null,'required' => false,
                'label'=> 'image'
            ])

            ->add('prix', MoneyType::class,array(
                'attr'=>array('class'=>'form-control')))

            ->add('stock',IntegerType::class)

                     ->add('save',SubmitType::class,array(
                         'label' =>'Valider',
                         'attr'=> array('class'=>'btn btn-success btn-lg ')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'validation_groups' => ['create'],

        ]);
    }
}
