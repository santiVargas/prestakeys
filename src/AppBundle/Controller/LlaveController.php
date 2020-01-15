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
     * @Route("/llave/nueva", name="llave_nueva", methods={"GET", "POST"})
     */
    public function nuevaAction(Request $request)
    {
        $nuevaLlave = new Llave();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevaLlave);

        return $this->formAction($request, $nuevaLlave);
    }

    /**
     * @Route("/llave/{id}", name="llave_form",
     *     requirements={"id"="\d+"}, methods={"GET", "POST"})
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
            'form' => $form->createView(),
            'llave' => $llave
        ]);
    }

    /**
     * @Route("/llave/eliminar/{id}", name="llave_eliminar", methods={"GET", "POST"})
     */
    public function eliminarAction(Request $request, Llave $llave)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($llave);
                $em->flush();
                $this->addFlash('success', 'Llave eliminada con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la llave');
                return $this->redirectToRoute('llave_form', ['id' => $llave->getId()]);
            }
        }
        return $this->render('llave/eliminar.html.twig', [
            'llave' => $llave
        ]);
    }
}