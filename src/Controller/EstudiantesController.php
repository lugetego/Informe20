<?php

namespace App\Controller;

use App\Entity\Estudiantes;
use App\Form\EstudiantesType;
use App\Repository\EstudiantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Estudiantes controller.
 *
 * @Route("/estudiantes")
 */

class EstudiantesController extends AbstractController
{
    /**
     * Lists all Estudiantes entities.
     * @Route("/anual/{actual}", name="estudiantes_index", methods={"GET"}, defaults={"actual"="2020"})
     */
    public function index($actual)
    {
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $estudiantes = $informe->getEstudiantes();
        $posdocs = $informe->getPosdocs();
        $enviado = $informe->isEnviado();

        return $this->render('estudiantes/index.html.twig', array(
            'estudiantes' => $estudiantes,
            'posdocs'=> $posdocs,
            'enviado'=>$enviado,
            'anual' => $actual,

        ));

    }

    /**
     * Creates a new Estudiantes entity.
     *
     * @Route("/new", name="estudiantes_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $estudiante = new Estudiantes();
        $form = $this->createForm('App\Form\EstudiantesType', $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $estudiante->setInforme($informe);
            $em->persist($estudiante);
            $em->flush();

            return $this->redirectToRoute('estudiantes_index');
            //return $this->redirectToRoute('dashboard');
        }

        return $this->render('estudiantes/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Estudiantes entity.
     * @Route("/{id}", name="estudiantes_show", methods={"GET"})
     */
    public function show(Estudiantes $estudiante)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $enviado = $informe->isEnviado();


        $deleteForm = $this->createDeleteForm($estudiante);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $estudiante);

        return $this->render('estudiantes/show.html.twig', array(
            'estudiante' => $estudiante,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Estudiantes entity.
     *
     * @Route("/{id}/edit", name="estudiantes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estudiantes $estudiante)
    {
        $deleteForm = $this->createDeleteForm($estudiante);
        $editForm = $this->createForm('App\Form\EstudiantesType', $estudiante);
//        $this->denyAccessUnlessGranted('edit', $estudiante);

        $editForm->remove('programas');
        $editForm->remove('programa');
        $editForm->add('programa','Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Programa'));

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();

            //return $this->redirectToRoute('estudiantes_show', array('id' => $estudiante->getId()));
            return $this->redirectToRoute('estudiantes_index');

        }

        return $this->render('estudiantes/edit.html.twig', array(
            'id'=>$estudiante->getId(),
            'estudiante' => $estudiante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Estudiantes entity.
     *
     * @Route("/{id}", name="estudiantes_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Estudiantes $estudiante)
    {
        $form = $this->createDeleteForm($estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estudiante);
            $em->flush();
        }

        return $this->redirectToRoute('estudiantes_index');
    }

    /**
     * Creates a form to delete a Estudiantes entity.
     *
     * @param Estudiantes $estudiante The Estudiantes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Estudiantes $estudiante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiantes_delete', array('id' => $estudiante->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}