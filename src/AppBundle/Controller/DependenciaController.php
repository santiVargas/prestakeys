<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dependencia;
use AppBundle\Repository\DependenciaRepository;
use AppBundle\Repository\LlaveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DependenciaController extends Controller
{
    /**
     * @Route("/dependencias", name="dependencia_listar")
     */
    public function indexAction(DependenciaRepository $dependenciaRepository)
    {
        $dependencias = $dependenciaRepository->findAllOrdenadas();

        return $this->render('dependencia/listar.html.twig', [
            'dependencias' => $dependencias
        ]);
    }

    /**
     * @Route("/dependencia/llaves/{id}", name="dependencia_llaves_listar")
     */
    public function llavesAction(LlaveRepository $llaveRepository, Dependencia $dependencia)
    {
        $llaves = $llaveRepository->findByDependencia($dependencia);

        return $this->render('dependencia/listar_llaves.html.twig', [
            'llaves' => $llaves,
            'dependencia' => $dependencia
        ]);
    }
}
