<?php

namespace App\Controller;

use App\Entity\Posdoc;
use App\Form\PosdocType;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/posdoc")
*/

class PosdocController extends AbstractController
{
    /**
     * @Route("/anual/{actual}", name="posdoc_index", methods={"GET"}, defaults={"actual"="2020"})
     */
    public function index($actual)
    {

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->get('security.context')->getToken()->getUser();
        $informe = $em->getRepository('InformeBundle:Informe')->findOneByAnio($actual, $user->getAcademico());
        $posdocs = $informe->getPosdocs();
        $enviado = $informe->isEnviado();


        //return $this->render('posdoc/index.html.twig', array(
        //  'posdocs' => $posdocs,
        //));
    }

    /**
     * @Route("/new", name="posdoc_new", methods={"GET","POST"})
     */
    public function newAction(Request $request): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $posdoc = new Posdoc();
        $form = $this->createForm('App\Form\PosdocType', $posdoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $posdoc->setInforme($informe);
            $em->persist($posdoc);
            $em->flush($posdoc);

            //return $this->redirectToRoute('posdoc_show', array('id' => $posdoc->getId()));
            return $this->redirectToRoute('estudiantes_index');
        }

        return $this->render('posdoc/new.html.twig', array(
            'posdoc' => $posdoc,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="posdoc_show", methods={"GET"})
     */
    public function show(Posdoc $posdoc)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $enviado = $informe->isEnviado();


        $deleteForm = $this->createDeleteForm($posdoc);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $posdoc);

        return $this->render('posdoc/show.html.twig', array(
            'posdoc' => $posdoc,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="posdoc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posdoc $posdoc)
    {

        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $deleteForm = $this->createDeleteForm($posdoc);
        $editForm = $this->createForm('App\Form\PosdocType', $posdoc);

//        $this->denyAccessUnlessGranted('edit', $posdoc);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('posdoc_edit', array('id' => $posdoc->getId()));
            return $this->redirectToRoute('estudiantes_index');

        }

        return $this->render('posdoc/edit.html.twig', array(
            'id'=>$posdoc->getId(),
            'posdoc' => $posdoc,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a posdoc entity.
     * @Route("/{id}", name="posdoc_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Posdoc $posdoc)
    {
        $form = $this->createDeleteForm($posdoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($posdoc);
            $em->flush($posdoc);
        }

        return $this->redirectToRoute('estudiantes_index');
    }

    /**
     * Creates a form to delete a posdoc entity.
     *
     * @param Posdoc $posdoc The posdoc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Posdoc $posdoc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('posdoc_delete', array('id' => $posdoc->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}