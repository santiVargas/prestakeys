<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Llave;
use AppBundle\Form\Type\LlaveType;
use AppBundle\Repository\LlaveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LlaveController extends Controller
{

    /**
     * @Route("/llaves", name="llave_listar")
     */
    public function indexAction(LlaveRepository $llaveRepository)
    {
        $llaves = $llaveRepository->findAllOrdenadosPorCodigo();

        return $this->render('llave/listar.html.twig', [
            'llaves' => $llaves
        ]);
    }

    /**
     * @Route("/llave/{id}", name="llave_form", methods={"GET", "POST"})
     */
    public function formAction(Request $request, Llave $llave)
    {
        $form = $this->createForm(LlaveType::class, $llave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la llave guardados con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('llave/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
