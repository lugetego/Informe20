<?php

namespace App\Controller;

use App\Entity\Proyectos;
use App\Form\ProyectosType;
use App\Repository\EstudiantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Proyectos controller.
 *
 * @Route("/proyectos")
 */
class ProyectosController extends AbstractController
{
    /**
     * Lists all Proyectos entities.
     *
     * @Route("/", name="proyectos_index", methods={"GET"})
     * @Route("/anual/{actual}", name="proyectos_index", methods={"GET"}, defaults={"actual"="2020"})


     */
    public function index($actual)
    {

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $proyectos = $informe->getProyectos();
        $enviado = $informe->isEnviado();


        return $this->render('proyectos/index.html.twig', array(
            'proyectos' => $proyectos,
            'enviado'=>$enviado,
            'anual'=>$actual,
        ));
    }

    /**
     * Creates a new Proyectos entity.
     *
     * @Route("/new", name="proyectos_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $proyecto = new Proyectos();
        $form = $this->createForm('App\Form\ProyectosType', $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $proyecto->setInforme($informe);
            $em->persist($proyecto);
            $em->flush();

            //return $this->redirectToRoute('proyectos_show', array('id' => $proyecto->getId()));
            return $this->redirectToRoute('proyectos_index');

        }

        return $this->render('proyectos/new.html.twig', array(
            'proyecto' => $proyecto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proyectos entity.
     *
     * @Route("/{id}", name="proyectos_show", methods={"GET"})
     */
    public function showAction(Proyectos $proyecto)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $enviado = $informe->isEnviado();

        $deleteForm = $this->createDeleteForm($proyecto);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $proyecto);

        return $this->render('proyectos/show.html.twig', array(
            'proyecto' => $proyecto,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proyectos entity.
     *
     * @Route("/{id}/edit", name="proyectos_edit", methods={"GET","POST"})
     */
    public function editAction(Request $request, Proyectos $proyecto)
    {
        $deleteForm = $this->createDeleteForm($proyecto);
//        $this->denyAccessUnlessGranted('edit', $proyecto);

        $editForm = $this->createForm('App\Form\ProyectosType', $proyecto);

        $editForm->remove('tipos');
        $editForm->remove('tipo');


        $editForm->add('tipo','Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Tipo de programa'));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyecto);
            $em->flush();

            //return $this->redirectToRoute('proyectos_show', array('id' => $proyecto->getId()));
            return $this->redirectToRoute('proyectos_index');

        }

        return $this->render('proyectos/edit.html.twig', array(
            'id'=>$proyecto->getId(),
            'proyecto' => $proyecto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Proyectos entity.
     *
     * @Route("/{id}", name="proyectos_delete", methods={"DELETE"})

     */
    public function deleteAction(Request $request, Proyectos $proyecto)
    {
        $form = $this->createDeleteForm($proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proyecto);
            $em->flush();
        }

        return $this->redirectToRoute('proyectos_index');
    }

    /**
     * Creates a form to delete a Proyectos entity.
     *
     * @param Proyectos $proyecto The Proyectos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proyectos $proyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyectos_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}