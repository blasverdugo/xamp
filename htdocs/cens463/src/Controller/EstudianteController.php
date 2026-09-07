<?php

namespace App\Controller;

use App\Entity\Estudiante;
use App\Form\EstudianteType;
use App\Repository\EstudianteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estudiante')]
final class EstudianteController extends AbstractController
{
    #[Route(name: 'app_estudiante_index', methods: ['GET'])]
    public function index(EstudianteRepository $estudianteRepository): Response
    {
        return $this->render('estudiante/index.html.twig', [
            'estudiantes' => $estudianteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estudiante_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estudiante = new Estudiante();
        $form = $this->createForm(EstudianteType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estudiante);
            $entityManager->flush();

            return $this->redirectToRoute('app_estudiante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudiante/new.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudiante_show', methods: ['GET'])]
    public function show(Estudiante $estudiante): Response
    {
        return $this->render('estudiante/show.html.twig', [
            'estudiante' => $estudiante,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estudiante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estudiante $estudiante, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstudianteType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estudiante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudiante/edit.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudiante_delete', methods: ['POST'])]
    public function delete(Request $request, Estudiante $estudiante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudiante->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($estudiante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estudiante_index', [], Response::HTTP_SEE_OTHER);
    }
}
