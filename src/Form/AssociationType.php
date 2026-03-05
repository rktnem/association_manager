<?php

namespace App\Form;

use App\Entity\Association;
use App\Entity\Commune;
use App\Entity\District;
use App\Entity\TypeAssociation;
use App\Helper\Helper;
use App\Repository\CommuneRepository;
use App\Repository\DistrictRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'association',
                'constraints' => new NotBlank(
                    message: "Cette champ doit être remplie et n'accepte pas d'espace"
                ),
                'attr' => [
                    'placeholder' => 'Nom de l\'association...'
                ]
            ])
            ->add('nombre_membre', NumberType::class, [
                'html5' => true,
                'label' => 'Nombre de membre',
                'constraints' => new NotBlank(
                    message: "Cette champ ne valide pas les espaces comme donnée."
                ),
                'attr' => [
                    'placeholder' => "Nombre de persone dans l'association..." 
                ]
            ])
            ->add('nom_president', TextType::class, [
                'label' => 'Nom du président(e)',
                'required' => false,
                'empty_data' => '',
                'constraints' => new Regex(
                    '/^[A-Za-zéèàôçùï ]+$/', 
                    message: "Le nom ne doit pas comporter des nombres ou de caractère spéciaux non courant."
                ),
                'attr' => [
                    'placeholder' => 'Nom du président(e)...'
                ]
            ])
            ->add('nif', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "NIF..."
                ]
            ])
            ->add('stat', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "STAT..."
                ]
            ])
            ->add('numero_recepisse', TextType::class, [
                'label' => 'Numéro du recépissé',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Numéro du recépissé...'
                ]
            ])
            ->add('contact', TextType::class, [
                'constraints' => new Regex(
                    '/^[0-9]+$/', 
                    message: "Le contact donné n'est pas valide."
                ),
                'attr' => [
                    'placeholder' => 'Contact...'
                ]
            ])
            ->add('compte_bancaire', TextType::class, [
                'required' => false,
                'constraints' => new Regex(
                    '/^[0-9]+$/', 
                    message: "Le numero de compte bancaire donné n'est pas valide."
                ),
                'attr' => [
                    'placeholder' => 'Compte bancaire...'
                ]
            ])
            ->add('district', EntityType::class, [
                'class' => District::class,
                'choice_label' => 'nom',
                'mapped' => false,
                'query_builder' => function (DistrictRepository $repository) {
                    return $this->orderDistrictList($repository);
                },
                'attr' => [
                    "data-action" => "change->association--form#selectDistrict"
                ],
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'query_builder' => function (CommuneRepository $repository) {
                    return $this->orderCommuneList($repository);
                },
                'choice_label' => 'nom',
            ])
            ->add('type_association', EntityType::class, [
                'class' => TypeAssociation::class, 
                'choice_label' => 'type',
            ])
            ->add("projet", ProjetType::class, [
                "label" => false
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->generateKeypass(...))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }

    private function orderCommuneList(
        CommuneRepository $repository
    ): QueryBuilder {
        return $repository->createQueryBuilder('c')
                ->orderBy('c.nom', 'ASC')
        ;
    }

    private function orderDistrictList(
        DistrictRepository $repository
    ): QueryBuilder {
        return $repository->createQueryBuilder('d')
                ->orderBy('d.nom', 'ASC')
        ;
    }

    public function generateKeypass(PostSubmitEvent $event): void {
        $data = $event->getData();

        $string = "ASS-";
        $nameSplit = explode(" ", strtoupper($data->getNom()));
        foreach($nameSplit as $item) {
            $string .= ($item . "-");
        }
        $string .= Helper::randomID();

        $data->setKeypass($string);
    }
}
