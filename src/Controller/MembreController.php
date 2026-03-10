<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\UserAssociation;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/member", name: "member.")]
#[IsGranted("IS_AUTHENTICATED")]
final class MembreController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, EntityManagerInterface $em, MembreRepository $repository): Response
    {
        /**
         * @var UserAssociation $user
        */
        $user = $this->getUser();
        $membre = new Membre();

        $membre->setAssociation($user->getAssociation());
        
        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        // Get all members
        $members = $repository->findAllMembers($user->getAssociation()->getId());

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($membre);
            $em->flush();

            $this->addFlash("success", "Nouveau membre ajouté");

            return $this->redirectToRoute("member.home");
        }

        return $this->render('membre/create.html.twig', [
            "form" => $form,
            "members" => $members
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, MembreRepository $repository, Membre $membre, EntityManagerInterface $em): Response
    {
        /**
         * @var UserAssociation $user
        */
        $user = $this->getUser();

        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($membre);
            $em->flush();

            $this->addFlash("success", "Modification du membre effectué");

            return $this->redirectToRoute("member.edit", ["id" => $membre->getId()]);
        }

        // Get all members
        $members = $repository->findAllMembers($user->getAssociation()->getId());

        return $this->render('membre/edit.html.twig', [
            "form" => $form,
            "members" => $members
        ]);
    }
}
