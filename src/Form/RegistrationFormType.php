<?php

namespace App\Form;

use App\Entity\UserAssociation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keypass', TextType::class, [
                "label" => "Clé d'accés",
                "row_attr" => [
                    "class" => "field-group"
                ]
            ])
            ->add("contact", TextType::class, [
                "row_attr" => [
                    "class" => "field-group"
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                "label" => "Mot de passe",
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
                "row_attr" => [
                    "class" => "field-group"
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter a password',
                    ),
                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        max: 4096,
                    ),
                ],
            ])
            ->add("confirmPassword", PasswordType::class, [
                "label" => "Confirmer mot de passe",
                "row_attr" => [
                    "class" => "field-group"
                ],
                "mapped" => false,
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue(
            //             message: 'You should agree to our terms.',
            //         ),
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAssociation::class,
        ]);
    }
}
