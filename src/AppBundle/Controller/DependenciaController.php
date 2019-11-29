<?php

namespace AppBundle\Controller;

use AppBundle\Repository\DependenciaRepository;
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
}
