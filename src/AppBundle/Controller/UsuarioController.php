<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Model\CambioClave;
use AppBundle\Form\Type\CambioClaveType;
use AppBundle\Form\Type\MiUsuarioType;
use AppBundle\Form\Type\UsuarioType;
use AppBundle\Repository\UsuarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios", name="usuario_listar")
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function indexAction(UsuarioRepository $usuarioRepository)
    {
        $usuarios  = $usuarioRepository->findAllOrdenadosPorApellidos();

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/usuario/nuevo", name="usuario_nuevo", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function nuevoAction(Request $request)
    {
        $nuevoUsuario = new Usuario();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevoUsuario);

        return $this->formAction($request, $nuevoUsuario);
    }

    /**
     * @Route("/usuario/{id}", name="usuario_form",
     *     requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function formAction(Request $request, Usuario $usuario)
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en el usuario guardados con éxito');
                return $this->redirectToRoute('usuario_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('usuario/form.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/usuario/eliminar/{id}", name="usuario_eliminar", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function eliminarAction(Request $request, Usuario $usuario)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($usuario);
                $em->flush();
                $this->addFlash('success', 'Usuario eliminado con éxito');
                return $this->redirectToRoute('usuario_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la llave');
                return $this->redirectToRoute('usuario_form', ['id' => $usuario->getId()]);
            }
        }
        return $this->render('usuario/eliminar.html.twig', [
            'usuario' => $usuario
        ]);
    }


    /**
     * @Route("/perfil", name="usuario_perfil",
     *                      methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function perfilAction(Request $request)
    {
        $usuario = $this->getUser();
        $form = $this->createForm(MiUsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en el usuario guardados con éxito');
                return $this->redirectToRoute('portada');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('usuario/perfil_form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/perfil/clave", name="usuario_cambiar_clave",
     *                      methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function cambioClaveAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $cambioClave = new CambioClave();

        $form = $this->createForm(CambioClaveType::class, $cambioClave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                /** @var Usuario $user */
                $user = $this->getUser();
                $user->setClave(
                    $encoder->encodePassword($user, $cambioClave->getNuevaClave())
                );
                $em->flush();
                $this->addFlash('success', 'Cambios en la contraseña guardados con éxito');
                return $this->redirectToRoute('usuario_perfil');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar la contraseña');
            }
        }
        return $this->render('usuario/cambio_clave_form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
