<?php

namespace App\Controller;

use App\Entity\Eventos;
use App\Form\EventosType;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Visistantes controller.
 *
 * @Route("/visitantes")
 */
class VisitantesController extends AbstractController
{
    /**
     * Lists all Visitantes entities.
     *
     * @Route("/", name="visitantes_index", methods={"GET"})
     * @Route("/anual/{actual}", name="visitantes_index", methods={"GET"}, defaults={"actual"="2020"})

     */
    public function index($actual)
    {

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $visitantes = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());

        $enviado = $informe->isEnviado();

        return $this->render('visitantes/index.html.twig', array(
            'visitantes' => $visitantes,
            'enviado'=>$enviado,
            'anual'=>$actual
        ));
    }

    /**
     * Creates a new Visitantes entity.
     *
     * @Route("/new", name="visitantes_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $evento = new Eventos();
        $form = $this->createForm('App\Form\VisitantesType', $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evento->setTipo('Visitante');
            $evento->setInforme($informe);
            $em->persist($evento);
            $em->flush();

            return $this->redirectToRoute('visitantes_index');
        }

        return $this->render('visitantes/new.html.twig', array(
            'evento' => $evento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Eventos entity.
     *
     * @Route("/{id}", name="visitantes_show", methods={"GET"})
     */
    public function show(Eventos $evento)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $enviado = $informe->isEnviado();

        $deleteForm = $this->createDeleteForm($evento);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $evento);

        return $this->render('visitantes/show.html.twig', array(
            'evento' => $evento,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Eventos entity.
     *
     * @Route("/{id}/edit", name="visitantes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Eventos $evento)
    {
        $deleteForm = $this->createDeleteForm($evento);
//        $this->denyAccessUnlessGranted('edit', $evento);
        $editForm = $this->createForm('App\Form\VisitantesType', $evento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);
            $em->flush();

            return $this->redirectToRoute('visitantes_index');

        }

        return $this->render('visitantes/edit.html.twig', array(
            'id'=>$evento->getId(),
            'evento' => $evento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Eventos entity.
     *
     * @Route("/{id}", name="visitantes_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Eventos $evento)
    {
        $form = $this->createDeleteForm($evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evento);
            $em->flush();
        }

        return $this->redirectToRoute('visitantes_index');
    }

    /**
     * Creates a form to delete a Eventos entity.
     *
     * @param Eventos $evento The Eventos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eventos $evento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visitantes_delete', array('id' => $evento->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}