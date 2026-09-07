<?php

namespace App\Controller;

use App\Entity\EstudioPrimario;
use App\Form\EstudioPrimarioType;
use App\Repository\EstudioPrimarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estudioprimario')]
final class EstudioPrimarioController extends AbstractController
{
    #[Route(name: 'app_estudio_primario_index', methods: ['GET'])]
    public function index(EstudioPrimarioRepository $estudioPrimarioRepository): Response
    {
        return $this->render('estudio_primario/index.html.twig', [
            'estudio_primarios' => $estudioPrimarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estudio_primario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estudioPrimario = new EstudioPrimario();
        $form = $this->createForm(EstudioPrimarioType::class, $estudioPrimario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estudioPrimario);
            $entityManager->flush();

            return $this->redirectToRoute('app_estudio_primario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudio_primario/new.html.twig', [
            'estudio_primario' => $estudioPrimario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudio_primario_show', methods: ['GET'])]
    public function show(EstudioPrimario $estudioPrimario): Response
    {
        return $this->render('estudio_primario/show.html.twig', [
            'estudio_primario' => $estudioPrimario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estudio_primario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EstudioPrimario $estudioPrimario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstudioPrimarioType::class, $estudioPrimario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estudio_primario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estudio_primario/edit.html.twig', [
            'estudio_primario' => $estudioPrimario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estudio_primario_delete', methods: ['POST'])]
    public function delete(Request $request, EstudioPrimario $estudioPrimario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudioPrimario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($estudioPrimario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estudio_primario_index', [], Response::HTTP_SEE_OTHER);
    }
}
