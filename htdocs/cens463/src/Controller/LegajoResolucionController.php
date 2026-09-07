<?php

namespace App\Controller;

use App\Entity\LegajoResolucion;
use App\Form\LegajoResolucionType;
use App\Repository\LegajoResolucionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/legajoresolucion')]
final class LegajoResolucionController extends AbstractController
{
    #[Route(name: 'app_legajo_resolucion_index', methods: ['GET'])]
    public function index(LegajoResolucionRepository $legajoResolucionRepository): Response
    {
        return $this->render('legajo_resolucion/index.html.twig', [
            'legajo_resolucions' => $legajoResolucionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_legajo_resolucion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $legajoResolucion = new LegajoResolucion();
        $form = $this->createForm(LegajoResolucionType::class, $legajoResolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($legajoResolucion);
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_resolucion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo_resolucion/new.html.twig', [
            'legajo_resolucion' => $legajoResolucion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_resolucion_show', methods: ['GET'])]
    public function show(LegajoResolucion $legajoResolucion): Response
    {
        return $this->render('legajo_resolucion/show.html.twig', [
            'legajo_resolucion' => $legajoResolucion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_legajo_resolucion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LegajoResolucion $legajoResolucion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LegajoResolucionType::class, $legajoResolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_resolucion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo_resolucion/edit.html.twig', [
            'legajo_resolucion' => $legajoResolucion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_resolucion_delete', methods: ['POST'])]
    public function delete(Request $request, LegajoResolucion $legajoResolucion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legajoResolucion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($legajoResolucion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_legajo_resolucion_index', [], Response::HTTP_SEE_OTHER);
    }
}
