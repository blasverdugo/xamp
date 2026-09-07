<?php

namespace App\Controller;

use App\Entity\Resolucion;
use App\Form\ResolucionType;
use App\Repository\ResolucionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/resolucion')]
final class ResolucionController extends AbstractController
{
    #[Route(name: 'app_resolucion_index', methods: ['GET'])]
    public function index(ResolucionRepository $resolucionRepository): Response
    {
        return $this->render('resolucion/index.html.twig', [
            'resolucions' => $resolucionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_resolucion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resolucion = new Resolucion();
        $form = $this->createForm(ResolucionType::class, $resolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resolucion);
            $entityManager->flush();

            return $this->redirectToRoute('app_resolucion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resolucion/new.html.twig', [
            'resolucion' => $resolucion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resolucion_show', methods: ['GET'])]
    public function show(Resolucion $resolucion): Response
    {
        return $this->render('resolucion/show.html.twig', [
            'resolucion' => $resolucion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resolucion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Resolucion $resolucion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResolucionType::class, $resolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_resolucion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resolucion/edit.html.twig', [
            'resolucion' => $resolucion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resolucion_delete', methods: ['POST'])]
    public function delete(Request $request, Resolucion $resolucion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resolucion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($resolucion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_resolucion_index', [], Response::HTTP_SEE_OTHER);
    }
}
