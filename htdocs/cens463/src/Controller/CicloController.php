<?php

namespace App\Controller;

use App\Entity\Ciclo;
use App\Form\CicloType;
use App\Repository\CicloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ciclo')]
final class CicloController extends AbstractController
{
    #[Route(name: 'app_ciclo_index', methods: ['GET'])]
    public function index(CicloRepository $cicloRepository): Response
    {
        return $this->render('ciclo/index.html.twig', [
            'ciclos' => $cicloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ciclo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ciclo = new Ciclo();
        $form = $this->createForm(CicloType::class, $ciclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ciclo);
            $entityManager->flush();

            return $this->redirectToRoute('app_ciclo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ciclo/new.html.twig', [
            'ciclo' => $ciclo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ciclo_show', methods: ['GET'])]
    public function show(Ciclo $ciclo): Response
    {
        return $this->render('ciclo/show.html.twig', [
            'ciclo' => $ciclo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ciclo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ciclo $ciclo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CicloType::class, $ciclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ciclo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ciclo/edit.html.twig', [
            'ciclo' => $ciclo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ciclo_delete', methods: ['POST'])]
    public function delete(Request $request, Ciclo $ciclo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ciclo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ciclo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ciclo_index', [], Response::HTTP_SEE_OTHER);
    }
}
