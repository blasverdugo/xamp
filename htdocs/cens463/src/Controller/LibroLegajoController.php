<?php

namespace App\Controller;

use App\Entity\LibroLegajo;
use App\Form\LibroLegajoType;
use App\Repository\LibroLegajoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/librolegajo')]
final class LibroLegajoController extends AbstractController
{
    #[Route(name: 'app_libro_legajo_index', methods: ['GET'])]
    public function index(LibroLegajoRepository $libroLegajoRepository): Response
    {
        return $this->render('libro_legajo/index.html.twig', [
            'libro_legajos' => $libroLegajoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_libro_legajo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $libroLegajo = new LibroLegajo();
        $form = $this->createForm(LibroLegajoType::class, $libroLegajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($libroLegajo);
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_legajo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_legajo/new.html.twig', [
            'libro_legajo' => $libroLegajo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_legajo_show', methods: ['GET'])]
    public function show(LibroLegajo $libroLegajo): Response
    {
        return $this->render('libro_legajo/show.html.twig', [
            'libro_legajo' => $libroLegajo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_libro_legajo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LibroLegajo $libroLegajo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LibroLegajoType::class, $libroLegajo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_legajo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_legajo/edit.html.twig', [
            'libro_legajo' => $libroLegajo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_legajo_delete', methods: ['POST'])]
    public function delete(Request $request, LibroLegajo $libroLegajo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$libroLegajo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($libroLegajo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_libro_legajo_index', [], Response::HTTP_SEE_OTHER);
    }
}
