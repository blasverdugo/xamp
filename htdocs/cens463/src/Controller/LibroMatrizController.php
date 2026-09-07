<?php

namespace App\Controller;

use App\Entity\LibroMatriz;
use App\Form\LibroMatrizType;
use App\Repository\LibroMatrizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/libromatriz')]
final class LibroMatrizController extends AbstractController
{
    #[Route(name: 'app_libro_matriz_index', methods: ['GET'])]
    public function index(LibroMatrizRepository $libroMatrizRepository): Response
    {
        return $this->render('libro_matriz/index.html.twig', [
            'libro_matrizs' => $libroMatrizRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_libro_matriz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $libroMatriz = new LibroMatriz();
        $form = $this->createForm(LibroMatrizType::class, $libroMatriz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($libroMatriz);
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_matriz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_matriz/new.html.twig', [
            'libro_matriz' => $libroMatriz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_matriz_show', methods: ['GET'])]
    public function show(LibroMatriz $libroMatriz): Response
    {
        return $this->render('libro_matriz/show.html.twig', [
            'libro_matriz' => $libroMatriz,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_libro_matriz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LibroMatriz $libroMatriz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LibroMatrizType::class, $libroMatriz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_matriz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_matriz/edit.html.twig', [
            'libro_matriz' => $libroMatriz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_matriz_delete', methods: ['POST'])]
    public function delete(Request $request, LibroMatriz $libroMatriz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$libroMatriz->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($libroMatriz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_libro_matriz_index', [], Response::HTTP_SEE_OTHER);
    }
}
