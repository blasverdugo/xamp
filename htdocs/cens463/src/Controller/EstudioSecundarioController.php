<?php

namespace App\Controller;

use App\Entity\EstudioSecundario;
use App\Form\EstudioSecundarioType;
use App\Repository\EstudioSecundarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estudiosecundario')]
final class EstudioSecundarioController extends AbstractController
{
    #[Route(name: 'app_estudio_secundario_index', methods: ['GET'])]
    public function index(EstudioSecundarioRepository $estudioSecundarioRepository): Response
    {
        return $this->render('estudio_secundario/index.html.twig', [
            'estudio_secundarios' => $estudioSecundarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estudio_secundario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estudioSecundario = new EstudioSecundario();
        $form = $this->createForm(EstudioSecundarioType::class, $estudioSecundario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estudioSecundario);
            $entityManager->flush();

            return $this->redirectToRoute('app_estudio_secundario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudio_secundario/new.html.twig', [
            'estudio_secundario' => $estudioSecundario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudio_secundario_show', methods: ['GET'])]
    public function show(EstudioSecundario $estudioSecundario): Response
    {
        return $this->render('estudio_secundario/show.html.twig', [
            'estudio_secundario' => $estudioSecundario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estudio_secundario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EstudioSecundario $estudioSecundario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstudioSecundarioType::class, $estudioSecundario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estudio_secundario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudio_secundario/edit.html.twig', [
            'estudio_secundario' => $estudioSecundario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudio_secundario_delete', methods: ['POST'])]
    public function delete(Request $request, EstudioSecundario $estudioSecundario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudioSecundario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($estudioSecundario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estudio_secundario_index', [], Response::HTTP_SEE_OTHER);
    }
}
