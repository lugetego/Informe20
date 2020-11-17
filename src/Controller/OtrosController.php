<?php

namespace App\Controller;

use App\Entity\Otros;
use App\Form\OtrosType;
use App\Repository\EstudiantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Otros controller.
 *
 * @Route("/otros")
 */
class OtrosController extends AbstractController
{
    /**
     * Lists all Otros entities.
     * @Route("/anual/{actual}", name="otros_index", methods={"GET"}, defaults={"actual"="2020"})
     */
    public function index($actual)
    {
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $otros = $informe->getotros();
        $enviado = $informe->isEnviado();


        return $this->render('otros/index.html.twig', array(
            'otros' => $otros,
            'enviado'=>$enviado,
            'anual'=>$actual,
        ));

    }

    /**
     * Creates a new Otros entity.
     *
     * @Route("/new", name="otros_new", methods={"GET","POST"})
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

        $otro = new Otros();
        $form = $this->createForm('App\Form\OtrosType', $otro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $otro->setInforme($informe);
            $em->persist($otro);
            $em->flush();

            return $this->redirectToRoute('otros_index');
            //return $this->redirectToRoute('dashboard');
        }

        return $this->render('otros/new.html.twig', array(
            'otro' => $otro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Otros entity.
     *
     * @Route("/{id}", name="otros_show", methods={"GET"})
     */
    public function showAction(Otros $otro)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $enviado = $informe->isEnviado();


        $deleteForm = $this->createDeleteForm($otro);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $otro);

        return $this->render('otros/show.html.twig', array(
            'otro' => $otro,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Otros entity.
     *
     * @Route("/{id}/edit", name="otros_edit", methods={"GET","POST"})
     */
    public function editAction(Request $request, Otros $otro)
    {
        $deleteForm = $this->createDeleteForm($otro);
        $editForm = $this->createForm('App\Form\OtrosType', $otro);
//        $this->denyAccessUnlessGranted('edit', $otro);

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($otro);
            $em->flush();

            //return $this->redirectToRoute('estudiantes_show', array('id' => $estudiante->getId()));
            return $this->redirectToRoute('otros_index');

        }

        return $this->render('otros/edit.html.twig', array(
            'id'=>$otro->getId(),
            'otro' => $otro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Otros entity.
     *
     * @Route("/{id}", name="otros_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Otros $otro)
    {
        $form = $this->createDeleteForm($otro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($otro);
            $em->flush();
        }

        return $this->redirectToRoute('otros_index');
    }

    /**
     * Creates a form to delete a Otros entity.
     *
     * @param Otros $estudiante The Otros entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Otros $otros)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('otros_delete', array('id' => $otros->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}