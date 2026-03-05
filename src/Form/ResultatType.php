<?php

namespace App\Form;

use App\Entity\Resultat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', NumberType::class, [
                "label" => "Quantité/Nombre produit",
                'required' => false,
                "row_attr" => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Quantité/nombre produit..."
                ]
            ])
            ->add('unite', TextType::class, [
                "label" => "Unité",
                "row_attr" => [
                    "class" => "field-group"
                ],
                'attr' => [
                    'placeholder' => 'Unité...'
                ],
                'required' => false,
            ])
            ->add('prixUnitaire', NumberType::class, [
                "row_attr" => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Prix unitaire..."
                ],
                'required' => false
            ])
            ->add('delaiProduction', TextType::class, [
                "label" => "Délai par production",
                "row_attr" => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Délai par production..."
                ],
                "required" => false
            ])
            ->add('explication', TextareaType::class, [
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
            'data_class' => Resultat::class,
        ]);
    }
}
