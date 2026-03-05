<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom du projet",
                "row_attr" => [
                    "class" => "field-group"
                ],
                'attr' => [
                    'placeholder' => 'Nom du projet...'
                ],
                "required" => true,
                "constraints" => new Sequentially([
                    new NotBlank(
                        message: "Cette champ doit être remplie et n'accepte pas d'espace"
                    ),
                    new Length(
                        min: 5, max: 50, minMessage: "Le nom du projet est trop court", maxMessage: "Le nom du projet est trop longue"
                    )
                ])
            ])
            ->add('budget', NumberType::class, [
                "label" => "Budget demandé",
                "row_attr" => [
                    "class" => "field-group"
                ],
                'attr' => [
                    'placeholder' => 'Budget demandé par l\'association...'
                ],
                "constraints" => [
                    new Sequentially([
                        new Type(
                            type: "numeric", message: "Le budget contient une lettre ou une caractère spéciaux"
                        ),
                        new Positive(
                            message: "Le budget ne peut pas être négatif"
                        )
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description du projet",
                "row_attr" => [
                    "class" => "field-group"
                ],
                "required" => true,
                "constraints" => new Length(
                    min: 15,
                    minMessage: "La description du projet est insuffisante"
                )
            ])
            ->add('strategie', TextareaType::class, [
                "label" => "Stratégie de mise en oeuvre",
                "row_attr" => [
                    "class" => "field-group"
                ],
                "required" => true,
                "constraints" => new Length(
                    min: 15,
                    minMessage: "La stratégie n'est pas bien décrite"
                )
            ])
            ->add("details", CollectionType::class, [
                "entry_type" => DetailType::class,
                "by_reference" => false,
                "allow_add" => true,
                "allow_delete" => true,
                "entry_options" => [
                    "label" => false
                ],
                "label" => false,
                "attr" => [
                    "data-controller" => "association--form-collection"
                ]
            ])
            ->add("resultat", ResultatType::class, [
                "label" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
