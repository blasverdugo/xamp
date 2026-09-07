<?php

namespace App\Controller;

use App\Entity\Orientada;
use App\Form\OrientadaType;
use App\Repository\OrientadaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/orientada')]
final class OrientadaController extends AbstractController
{
    #[Route(name: 'app_orientada_index', methods: ['GET'])]
    public function index(OrientadaRepository $orientadaRepository): Response
    {
        return $this->render('orientada/index.html.twig', [
            'orientadas' => $orientadaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orientada_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $orientada = new Orientada();
        $form = $this->createForm(OrientadaType::class, $orientada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($orientada);
            $entityManager->flush();

            return $this->redirectToRoute('app_orientada_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orientada/new.html.twig', [
            'orientada' => $orientada,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orientada_show', methods: ['GET'])]
    public function show(Orientada $orientada): Response
    {
        return $this->render('orientada/show.html.twig', [
            'orientada' => $orientada,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orientada_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orientada $orientada, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrientadaType::class, $orientada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_orientada_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orientada/edit.html.twig', [
            'orientada' => $orientada,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orientada_delete', methods: ['POST'])]
    public function delete(Request $request, Orientada $orientada, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orientada->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($orientada);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_orientada_index', [], Response::HTTP_SEE_OTHER);
    }
}
