<?php

namespace App\Controller;

use App\Entity\Estudiante;
use App\Entity\Institucion;
use App\Entity\Resolucion;
//use App\Entity\CensLegajo;
use App\Entity\Asignatura;
//use App\Entity\CensMateria;
use App\Entity\EstudioPrimario;
use App\Entity\EstudioSecundario;
use App\Entity\Legajo;
use App\Repository\EstudianteRepository;
use App\Form\NexoLegajoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;



final class NexoLegajoController extends AbstractController
{
    #[Route('/nexolegajo', name: 'app_nexolegajo')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $dni = $request->query->get('dni');

        $qb = $em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Estudiante', 'e');

        if ($dni) {
            // Si se envía DNI, filtramos por él
            $qb->where('e.dni = :dni')
            ->setParameter('dni', $dni);
        } else {
            // Si no se envía DNI, traemos los últimos 200 por ID descendente
            $qb->orderBy('e.id', 'DESC')
            ->setMaxResults(200);
        }

        $estudiantes = $qb->getQuery()->getResult();

        return $this->render('nexolegajo/index.html.twig', [
            'estudiantes' => $estudiantes,
            'dni' => $dni,
        ]);
    }

    #[Route('/nexolegajo/new', name: 'nexo_legajo_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NexoLegajoType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            // Validaciones propias
            $data = $form->getData();
            $newEstudiante = $data['estudiante'] ?? null;

            if (!$newEstudiante) {
                $this->addFlash('error', 'Debe crear un estudiante.');
                return $this->redirectToRoute('gestion_estudiante_new');           
            }

            // Solo continuar si Symfony y tus validaciones están OK
            if ($form->isValid()) {
                $data = $form->getData();

                $estudiante = $newEstudiante;
                $em->persist($estudiante);

                $legajo = $data['legajo'] ?? null;

                //----------------------------
                //Persistencia de asignaturas 
                //----------------------------
                $resolucion = $legajo->getResolucion();
                $cicloOrientado = $legajo->getCiclo();
                if ($resolucion) {
                    $legajoResolucion = $em
                        ->getRepository(LegajoResolucion::class)
                        ->findOneBy([
                            'legajo' => $legajo,
                            'resolucion' => $resolucion,
                        ]);
                    if (!$legajoResolucion) { //tabla intermendia historica
                        $legajoResolucion = new LegajoResolucion();
                        $legajoResolucion->setLegajo($legajo);
                        $legajoResolucion->setResolucion($resolucion);
                        $legajoResolucion->setFecha($legajo->getFecha());
                        $em->persist($legajoResolucion);
                    }
                    // TODAS las asignaturas de la resolución.
                    $asignaturas = $em
                        ->getRepository(Asignatura::class)
                        ->findBy([
                            'resolucion' => $resolucion,
                        ]);
                    $asignaturasBasicas = [];
                    $asignaturasOrientadas = [];
                    //1. OBTENER SIEMPRE LAS ASIGNATURAS DEL CICLO BÁSICO
                    foreach ($asignaturas as $asignatura) {
                        $cicloAsignatura = $asignatura->getCiclo();
                        if (!$cicloAsignatura) {
                            continue;
                        }
                        if ($cicloAsignatura->getTipo() === 'basico') {
                            $asignaturasBasicas[] = $asignatura;
                        }
                    }
                    // 2. OBTENER EL CICLO ORIENTADO DEL LEGAJO 
                    if ($cicloOrientado) {
                        foreach ($asignaturas as $asignatura) {
                            $cicloAsignatura = $asignatura->getCiclo();
                            if (!$cicloAsignatura) {
                                continue;
                            }
                            //El ciclo de la asignatura debe coincidir con el ciclo elegido en el legajo.
                            if (
                                $cicloAsignatura->getTipo() === 'orientado'
                                && $cicloAsignatura->getId() === $cicloOrientado->getId()
                            ) {
                                $asignaturasOrientadas[] = $asignatura;
                            }
                        }
                    }
                    // 3. PERSISTIR SIEMPRE LAS BASICAS
                    foreach ($asignaturasBasicas as $asignatura) {
                        $legajoAsignatura = new LegajoAsignatura();
                        $legajoAsignatura->setLegajo($legajo);
                        $legajoAsignatura->setLegajoResolucion($legajoResolucion);
                        $legajoAsignatura->setAsignatura($asignatura);
                        $em->persist($legajoAsignatura);
                    }
                    // 4. PERSISTIR LAS ORIENTADAS SI EXISTE CICLO
                    foreach ($asignaturasOrientadas as $asignatura) {
                        $legajoAsignatura = new LegajoAsignatura();
                        $legajoAsignatura->setLegajo($legajo);
                        $legajoAsignatura->setLegajoResolucion($legajoResolucion);
                        $legajoAsignatura->setAsignatura($asignatura);
                        $em->persist($legajoAsignatura);
                    }
                }

                $estudioPrimario = $data['estudioPrimario'] ?? null;
                if ($this->tieneDatosEstudioPrimario($estudioPrimario)) {
                    $archivoPrimario = $form->get('estudioPrimario')->get('foto_analitico')->getData();
                    if ($archivoPrimario) { $estudioPrimario->setFotoAnalitico(file_get_contents($archivoPrimario->getPathname()));}
                    $estudioPrimario->setEstudiante($estudiante);
                    $em->persist($estudioPrimario);
                }
                $estudioSecundario = $data['estudioSecundario'] ?? null;
                if ($this->tieneDatosEstudioSecundario($estudioSecundario)) {
                    $archivoSecundario = $form->get('estudioSecundario')->get('foto_analitico')->getData();
                    if ($archivoSecundario) { $estudioSecundario->setFotoAnalitico(file_get_contents($archivoSecundario->getPathname())); }
                    $estudioSecundario->setEstudiante($estudiante);
                    $em->persist($estudioSecundario);
                }
                
                $em->flush();
                $this->addFlash('success', 'Estudiante creado correctamente');
                return $this->redirectToRoute('app_nexolegajo');
            }
        }
        return $this->render('nexolegajo/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/nexolegajo/resoluciones/{id}', name: 'ajax_resoluciones')]
    public function resoluciones(int $id,Institucion $institucion, EntityManagerInterface $em): JsonResponse {
        $datos = [];
        foreach ($institucion->getResolucions() as $resolucion) {
            $datos[] = [
                'id' => $resolucion->getId(),
                'numero' => $resolucion->getNumero(),
            ];
        }
        return $this->json($datos);
    }

    #[Route('/nexolegajo/ciclos/{id}', name: 'ajax_ciclos')]
    public function ciclos(Resolucion $resolucion): JsonResponse
    {
        $datos = [];
        foreach ($resolucion->getCiclos() as $ciclo) {
            if ($ciclo->getNombre() === 'Basico') {
                continue;
            }
            $datos[] = [
                'id' => $ciclo->getId(),
                'nombre' => $ciclo->getNombre(),
            ];
        }
        return $this->json($datos);
    }



    
    #[Route('/nexolegajo/{id}/edit', name: 'nexo_legajo_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $estudiante = $em->getRepository(Estudiante::class)->find($id);
       // if (!$estudiante) {throw $this->createNotFoundException('Estudiante no encontrado'); }
        if (!$estudiante) {
            $this->addFlash('error', 'El estudiante no se encontró.');
            return $this->redirectToRoute('app_gestion_estudiante');
        }
        // Cargar entidades relacionadas
        $legajo = $em->getRepository(Legajo::class)->findOneBy([ 'estudiante' => $estudiante]);
        
        $estudioPrimario = $em->getRepository(EstudioPrimario::class)->findOneBy([ 'legajo' => $legajo ]);
        //$estudioSecundario = $em->getRepository(EstudioSecundario::class)->findOneBy([ 'legajo' => $legajo ]);

        $formData = [
            'estudiante' => $estudiante,
            'estudioPrimario' => $estudioPrimario,
            //'estudioSecundario' => $estudioSecundario,
            'legajo' => $legajo,
        ];
 
        $form = $this->createForm(NexoLegajoType::class, $formData);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $estudiante = $data['estudiante'];

            $em->persist($estudiante);
            

            $legajo = $data['legajo'];
            // Primera validación de negocio si no hay legajo cortar la secuencia
            if (!$this->tieneDatosLegajo($legajo)) {
                $this->addFlash('error', 'Debe completar los datos del legajo.');
                return $this->redirectToRoute('nexo_legajo_edit', [ 'id' => $id,]);
            }


            $legajo->setEstudiante($estudiante);
            $em->persist($legajo);

            $estudioPrimario = $data['estudioPrimario'];
            if ($this->tieneDatosEstudioPrimario($estudioPrimario)) {
                $estudioPrimario->setLegajo($legajo);

                $archivoPrimario = $form->get('estudioPrimario')->get('foto_analitico')->getData();
                if ($archivoPrimario) {
                    $estudioPrimario->setFotoAnalitico(
                        file_get_contents($archivoPrimario->getPathname())
                    );
                }

                $em->persist($estudioPrimario);
            } elseif ($estudioPrimario) {
                $em->remove($estudioPrimario);
            }

            $estudioSecundario = $data['estudioSecundario'];
            if ($this->tieneDatosEstudioSecundario($estudioSecundario)) {
                $estudioSecundario->setLegajo($legajo);

                $archivoSecundario = $form->get('estudioSecundario')->get('foto_analitico')->getData();
                if ($archivoSecundario) {
                    $estudioSecundario->setFotoAnalitico(
                        file_get_contents($archivoSecundario->getPathname())
                    );
                }

                $em->persist($estudioSecundario);
            } elseif ($estudioSecundario) {
                $em->remove($estudioSecundario);
            }
  
            /*if ($this->tieneDatosLegajo($legajoNuevo)) {
                $legajoNuevo->setEstudiante($estudiante);
                // Obtener legajo original de BD para comparar cens
                $legajoOriginal = null;
                if ($legajoNuevo->getId()) {$legajoOriginal = $em->getRepository(Legajo::class)->find($legajoNuevo->getId());}
                $em->persist($legajoNuevo);
                    $censNuevo = $legajoNuevo->getCens();
                    $censOriginal = $legajoOriginal ? $legajoOriginal->getCens() : null;
                        $censLegajoExistente = $em->getRepository(CensLegajo::class)->findOneBy([
                            'legajo' => $legajoNuevo,
                            'cens' => $censNuevo,
                        ]);
                        if (!$censLegajoExistente) {
                            $legajoNuevo->setEstudiante($estudiante);
                            $em->persist($legajoNuevo);
                            $cens = $legajoNuevo->getCens();
                            if ($cens) {
                                $censLegajo = $em->getRepository(CensLegajo::class)->findOneBy([
                                    'legajo' => $legajoNuevo,
                                    'cens' => $cens,
                                ]);
                                if (!$censLegajo) {
                                    $censLegajo = new CensLegajo();
                                    $censLegajo->setLegajo($legajoNuevo);
                                    $censLegajo->setCens($cens);
                                    $censLegajo->setFechaAsociacion($legajoNuevo->getFecha());
                                    $em->persist($censLegajo);
                                }
                                $materias = $em->getRepository(Materia::class)->findBy(['cens' => $cens]);
                                foreach ($materias as $materia) {
                                    $censMateria = new CensMateria();
                                    $censMateria->setLegajo($legajoNuevo);
                                    $censMateria->setCensLegajo($censLegajo);
                                    $censMateria->setMateria($materia);
                                    $em->persist($censMateria);
                                }
                            }
                        }                    
            } elseif ($legajoNuevo) {
                $em->remove($legajoNuevo);
            }*/
            $em->flush();
            $this->addFlash('success', 'Estudiante actualizado correctamente');
            return $this->redirectToRoute('app_nexolegajo');
        }

    
        return $this->render('nexolegajo/form.html.twig', [
            'form' => $form->createView(),
            'estudiante' => $estudiante,
        ]);
        
    }

    
    private function tieneDatosEstudioPrimario(?EstudioPrimario $ep): bool
    {
        return $ep !== null && !empty($ep->getNumero());
    }
    private function tieneDatosEstudioSecundario(?EstudioSecundario $es): bool
    {
        return $es !== null && !empty($es->getNumero());
    }
    private function tieneDatosLegajo(?Legajo $legajo): bool
    {
        return $legajo !== null && !empty($legajo->getTurno());
    }

    
}

