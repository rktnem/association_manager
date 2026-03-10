<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "row_attr"  => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Nom du membre..."
                ],
            ])
            ->add('prenom', TextType::class, [
                "row_attr"  => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Prénom du membre..."
                ]
            ])
            ->add('role', TextType::class, [
                "row_attr"  => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Son rôle dans l'association..."
                ]
            ])
            ->add('adresse', TextType::class, [
                "row_attr"  => [
                    "class" => "field-group"
                ],
                "attr" => [
                    "placeholder" => "Adresse du membre..."
                ]
            ])
            ->add('birthday', DateType::class, [
                "row_attr"  => [
                    "class" => "field-group"
                ],
            ])
            ->add("button", SubmitType::class, [
                "label" => "Ajouter",
                "row_attr" => [
                    "class" => "btn-wrapper"
                ],
                "attr" => [
                    "class" => "btn"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
