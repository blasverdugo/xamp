<?php

namespace App\Controller;

use App\Entity\LegajoAsignatura;
use App\Form\LegajoAsignaturaType;
use App\Repository\LegajoAsignaturaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/legajoasignatura')]
final class LegajoAsignaturaController extends AbstractController
{
    #[Route(name: 'app_legajo_asignatura_index', methods: ['GET'])]
    public function index(LegajoAsignaturaRepository $legajoAsignaturaRepository): Response
    {
        return $this->render('legajo_asignatura/index.html.twig', [
            'legajo_asignaturas' => $legajoAsignaturaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_legajo_asignatura_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $legajoAsignatura = new LegajoAsignatura();
        $form = $this->createForm(LegajoAsignaturaType::class, $legajoAsignatura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($legajoAsignatura);
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_asignatura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo_asignatura/new.html.twig', [
            'legajo_asignatura' => $legajoAsignatura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_asignatura_show', methods: ['GET'])]
    public function show(LegajoAsignatura $legajoAsignatura): Response
    {
        return $this->render('legajo_asignatura/show.html.twig', [
            'legajo_asignatura' => $legajoAsignatura,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_legajo_asignatura_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LegajoAsignatura $legajoAsignatura, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LegajoAsignaturaType::class, $legajoAsignatura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_legajo_asignatura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legajo_asignatura/edit.html.twig', [
            'legajo_asignatura' => $legajoAsignatura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legajo_asignatura_delete', methods: ['POST'])]
    public function delete(Request $request, LegajoAsignatura $legajoAsignatura, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legajoAsignatura->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($legajoAsignatura);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_legajo_asignatura_index', [], Response::HTTP_SEE_OTHER);
    }
}
