<?php

namespace App\Form;

use App\Entity\Detail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, [
                "row_attr" => [
                    "class" => "field-group"
                ],
                'attr' => [
                    'placeholder' => 'Désignation matériel/produit...'
                ],
                'required' => true,
                'constraints' => new NotBlank(
                    message: "Cette champ ne valide pas les espaces comme donnée."
                ),
            ])
            ->add('nombre', NumberType::class, [
                "label" => "Quantité/Nombre",
                "row_attr" => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Quantité/nombre requis..."
                ],
                'required' => true
            ])
            ->add('unite', TextType::class, [
                "label" => "Unité",
                "row_attr" => [
                    "class" => "field-group"
                ],
                'attr' => [
                    'placeholder' => 'Unité...'
                ],
                'required' => true,
                'constraints' => new NotBlank(
                    message: "Cette champ ne valide pas les espaces comme donnée."
                ),
            ])
            ->add('prixUnitaire', NumberType::class, [
                "row_attr" => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Prix unitaire..."
                ],
                'required' => true
            ])
            ->add('observation', TextareaType::class, [
                "required" => false,
                "row_attr" => [
                    "class" => "field-group"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Detail::class,
        ]);
    }
}
