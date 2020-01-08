<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Llave;
use AppBundle\Form\Type\LlaveType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LlaveController extends Controller
{
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
                return $this->redirectToRoute('llave_listar');
            }
            catch(\Exception $e) {

            }
        }
        return $this->render('llave/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
