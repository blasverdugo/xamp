<?php

namespace App\Controller;

use App\Entity\Resolucion;
use App\Entity\Asignatura;
use App\Repository\ResolucionRepository;
use App\Repository\AsignaturaRepository;
use App\Form\NexoResolucionType;
use App\Form\NexoAsignaturaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NexoresolucionController extends AbstractController
{
    #[Route('/nexoresolucion', name: 'app_nexoresolucion', methods : ['GET'])]
    public function index(ResolucionRepository $resolucionRepository): Response
    {
        return $this->render('nexoresolucion/index.html.twig', [
            'resoluciones' => $resolucionRepository->findAll(),
        ]);
    }
}

/*
<?php

namespace App\Controller;

use App\Entity\Cens;
use App\Entity\Materia;
use App\Repository\CensRepository;
use App\Repository\MateriaRepository;
use App\Form\GestionMateriaForm;
use App\Form\GMForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GestionMateriaController extends AbstractController
{
    #[Route('/gestionmateria', name: 'app_gestion_materia', methods: ['GET'])]
    public function index(CensRepository $censRepository): Response
    {
        return $this->render('gestion_materia/index.html.twig', [
            'cens' => $censRepository->findAll(),
        ]);
    }


    #[Route('/gestionmateria/new', name: 'app_gestion_materia_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GestionMateriaForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newCens = $data['nuevoCens'] ?? null;       // Cens nuevo 
            // Validaciones básicas
            if (!$newCens) {
                $form->addError(new FormError('Debe Crear un CENS.'));
            } else {
                $cens = $newCens;
                // Si es Cens nuevo, persistirlo primero (no hace falta flush para que $cens sea usable)
                if ($newCens) {
                    $em->persist($newCens);
                }
                // Materias es una colección de entidades Materia (por by_reference=false)
                foreach ($data['materias'] as $materia) {
                    $materia->setCens($cens);
                    $em->persist($materia);
                }
                $em->flush();
                $this->addFlash('success', 'Materias cargadas correctamente.');
                return $this->redirectToRoute('app_gestion_materia');
            }
        }
        return $this->render('gestion_materia/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/gestionmateria/{id}/edit', name: 'app_gestion_materia_edit')]
    public function edit(Cens $cens, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GestionMateriaForm::class, [
            'materias' => $cens->getMaterias()->toArray(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $materias = $data['materias'];
            foreach ($materias as $materia) {
                // Asignar el Cens siempre
                $materia->setCens($cens);
                // Si es nueva (sin ID), persistir
                if ($materia->getId() === null) {
                    $em->persist($materia);
                }
                // Si ya existe, no hace falta persistir manualmente porque Doctrine la sigue
            }
            $em->flush();
            $this->addFlash('success', 'Materias actualizadas correctamente.');
            return $this->redirectToRoute('app_gestion_materia');
        }
        return $this->render('gestion_materia/edit.html.twig', [
            'form' => $form->createView(),
            'cens' => $cens,
        ]);
    }


}*/
