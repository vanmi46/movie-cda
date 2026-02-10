<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DirectorRepository;

final class DirectorController extends AbstractController
{
    #[Route('/director', name: 'app_director', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($director);
            $em->flush();

            $this->addFlash('success', 'Réalisateur ajouté avec succès.');

            return $this->redirectToRoute('app_director');
        }

        return $this->render('director/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/director/all', name: 'director_all', methods: ['GET'])]
    public function showAll(DirectorRepository $directorRepository): Response
    {
        $directors = $directorRepository->findAll();

        return $this->render('director/show_all_director.html.twig', [
            'directors' => $directors,
        ]);
}
}
