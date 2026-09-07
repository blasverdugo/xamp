<?php

namespace App\Controller;

use App\Entity\Legajo;
use App\Form\LegajoType;
use App\Repository\LegajoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/legajo')]
final class LegajoController extends AbstractController
{
    #[Route(name: 'app_legajo_index', methods: ['GET'])]
    public function index(LegajoRepository $legajoRepository): Response
    {
        return $this->render('legajo/index.html.twig', [
            'legajos' => $legajoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_legajo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $legajo = new Legajo();
        $form = $this->createForm(LegajoType::class, $legajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($legajo);
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo/new.html.twig', [
            'legajo' => $legajo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_show', methods: ['GET'])]
    public function show(Legajo $legajo): Response
    {
        return $this->render('legajo/show.html.twig', [
            'legajo' => $legajo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_legajo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Legajo $legajo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LegajoType::class, $legajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo/edit.html.twig', [
            'legajo' => $legajo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_delete', methods: ['POST'])]
    public function delete(Request $request, Legajo $legajo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legajo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($legajo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_legajo_index', [], Response::HTTP_SEE_OTHER);
    }
}
