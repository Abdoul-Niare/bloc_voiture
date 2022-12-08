<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Marque;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre de l\'annonce',
            'attr' => [
                'placeholder' => 'Entrez le titre votre annonce'
            ]])
        ->add('description', CkeditorType::class, [
            'label' => 'Informations de l\'évènement'
        ])
        ->add('model', TextType::class, [
            'label' => 'Modèle de voiture',
            'attr' => [
                'placeholder' => 'Entrez le modèle de la voiture'
            ]])
        ->add('prix', NumberType:: class ,[
            'label' => 'Prix du bien',
        ])
        ->add('year', NumberType:: class ,[
            'label' => 'Année de sortie',
        ])
        ->add('km', NumberType:: class ,[
            'label' => 'Kilométrage du véhicule',
        ])
        ->add('fuel', TextType::class, [
            'label' => 'Type de carburant',
            'attr' => [
                'placeholder' => 'Essence / Diesel / Électrique'
            ]])
        ->add('licence', CheckboxType::class, [
            'label' => 'Véhicule nécessitant le permis',
            'required' => false,
        ])
        ->add('imgfile', FileType::class, [
            'label' => 'Photo de la voiture',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                ])
            ],
        ])
        ->add('marque', EntityType::class, [
            'choice_label'=> 'name',
            'class'=> Marque::class,
            'label'=>'Choix de la marque',
            'multiple' => false,
            'expanded' => true,
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
