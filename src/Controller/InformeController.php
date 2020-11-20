<?php

namespace App\Controller;

use App\Entity\Informe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Informe controller.
 *
 * @Route("informe")
 */
class InformeController extends AbstractController
{
    /**
     * Lists all informe entities.
     *
     * @Route("/", name="informe_index", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $informes = $em->getRepository('App:Informe')->findAll();

        return $this->render('informe/index.html.twig', array(
            'informes' => $informes,
        ));
    }

    /**
     * Creates a new informe entity.
     *
     * @Route("/new", name="informe_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $informe = new Informe();
        $form = $this->createForm('InformeBundle\Form\InformeType', $informe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($informe);
            $em->flush();

            return $this->redirectToRoute('informe_show', array('id' => $informe->getId()));
        }

        return $this->render('informe/new.html.twig', array(
            'informe' => $informe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a informe entity.
     *
     * @Route("/{id}", name="informe_show", methods={"GET"})
     */
    public function show(Informe $informe)
    {
        $deleteForm = $this->createDeleteForm($informe);

        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $plan = $em->getRepository('App:Plan')->findOneByAnio($informe->getAnio()+1,$academico);

        $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());
        $visitas = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());



        return $this->render('informe/show.html.twig', array(
            'informe' => $informe,
            'academico' => $academico,
            'plan' => $plan,
            'eventos' => $eventos,
            'visitas' => $visitas,

            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing informe entity.
     *
     * @Route("/{id}/edit", name="informe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Informe $informe)
    {
        $deleteForm = $this->createDeleteForm($informe);
        $editForm = $this->createForm('App\Form\InformeType', $informe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('informe_edit', array('id' => $informe->getId()));
            return $this->redirectToRoute('dashboard');

        }

        return $this->render('informe/edit.html.twig', array(
            'informe' => $informe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a informe entity.
     *
     * @Route("/{id}", name="informe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Informe $informe)
    {
        $form = $this->createDeleteForm($informe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($informe);
            $em->flush();
        }

        return $this->redirectToRoute('informe_index');
    }

    /**
     * Creates a form to delete a informe entity.
     *
     * @param Informe $informe The informe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Informe $informe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informe_delete', array('id' => $informe->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}