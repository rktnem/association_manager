<?php

namespace App\Controller;

use App\Entity\UserAssociation;
use App\Form\RegistrationFormType;
use App\Helper\Utilities;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
        Security $security, EntityManagerInterface $entityManager, AssociationRepository $associationRepository): Response
    {
        $user = new UserAssociation();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get association by keypass and contact
            $association = $associationRepository->findOneBy([
                "keypass" => $form->get("keypass")->getData(),
                "contact" => $form->get("contact")->getData()
            ]);
            
            // verify correspondence between keypass and contact
            if ($association == null) {
                $form->addError(new FormError("Les informations sont erronés"));
                Utilities::handleError($form, "keypass", "Vérifiez votre clé d'accés");
                Utilities::handleError($form, "contact", "Ou vérifier votre contact");
                
                return $this->render("registration/register.html.twig", [
                    'registrationForm' => $form
                ]);
            }

            if (
                $form->get('plainPassword')->getData() 
                !== 
                $form->get('confirmPassword')->getData()
            ) {
                Utilities::handleError($form, "confirmPassword", "Le mot de passe ne corresponde pas");
                return $this->render("registration/register.html.twig", [
                    'registrationForm' => $form
                ]);
            }
            
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // set association data
            $user->setAssociation($association);

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
