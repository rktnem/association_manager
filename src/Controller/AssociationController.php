<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\UserAssociation;
use App\Form\AssociationType;
use App\Form\ProjetType;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/association", name: "association.")]
#[IsGranted("IS_AUTHENTICATED")]
final class AssociationController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AssociationRepository $repository, EntityManagerInterface $em, Request $request): Response
    {
        /**
         * @var UserAssociation $user
         */
        $user = $this->getUser();
        $associationId = $user->getAssociation()->getId();

        $association = $repository->find($associationId);

        // Create association form
        $form = $this->createForm(ProjetType::class, $association->getProjet());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash("success", "Modification effectué");
        }
        
        return $this->render('association/index.html.twig', [
            "form" => $form,
            "association" => $association
        ]);
    }
}
