<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('attr'=>
            array('class'=>'form-control')))
            ->add('description',TextareaType::class,array(
                'attr'=> array('class'=>'form-control')))
                
            ->add('image', FileType::class,[
                'data_class' => null,'required' => false,
               'label'=> 'image'
           ])
                    ->add('save',SubmitType::class,array(
                        'label' =>'Valider',
                        'attr'=> array('class'=>'btn btn-success btn-lg ')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
