<?php

namespace App\Controller;

use App\Entity\LibroNota;
use App\Form\LibroNotaType;
use App\Repository\LibroNotaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/libronota')]
final class LibroNotaController extends AbstractController
{
    #[Route(name: 'app_libro_nota_index', methods: ['GET'])]
    public function index(LibroNotaRepository $libroNotaRepository): Response
    {
        return $this->render('libro_nota/index.html.twig', [
            'libro_notas' => $libroNotaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_libro_nota_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $libroNotum = new LibroNota();
        $form = $this->createForm(LibroNotaType::class, $libroNotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($libroNotum);
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_nota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_nota/new.html.twig', [
            'libro_notum' => $libroNotum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_nota_show', methods: ['GET'])]
    public function show(LibroNota $libroNotum): Response
    {
        return $this->render('libro_nota/show.html.twig', [
            'libro_notum' => $libroNotum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_libro_nota_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LibroNota $libroNotum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LibroNotaType::class, $libroNotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_nota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('libro_nota/edit.html.twig', [
            'libro_notum' => $libroNotum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_nota_delete', methods: ['POST'])]
    public function delete(Request $request, LibroNota $libroNotum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$libroNotum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($libroNotum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_libro_nota_index', [], Response::HTTP_SEE_OTHER);
    }
}
