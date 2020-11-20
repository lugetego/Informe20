<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Form\PlanType;
use App\Entity\Academico;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Plan controller.
 *
 * @Route("/plan")
 */
class PlanController extends AbstractController
{
    /**
     * Lists all Plan entities.
     *
     * @Route("/", name="plan_index", methods={"GET"})

     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('InformeBundle:Plan')->findAll();

        return $this->render('plan/index.html.twig', array(
            'plans' => $plans,
        ));
    }

    /**
     * Creates a new Plan entity.
     *
     * @Route("/new", name="plan_new", methods={"GET","POST"})
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

        $plan = new Plan();
        $form = $this->createForm('App\Form\PlanType', $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $plan->setAcademico($academico);
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('plan/new.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plan entity.
     *
     * @Route("/{id}", name="plan_show", methods={"GET"})
     */
    public function show(Plan $plan)
    {

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();


        $deleteForm = $this->createDeleteForm($plan);

        // check for "view" access: calls all voters
        //$this->denyAccessUnlessGranted('view', $plan);

        return $this->render('plan/show.html.twig', array(
            'academico'=>$academico,
            'plan' => $plan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plan entity.
     *
     * @Route("/{id}/edit", name="plan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plan $plan)
    {
//        $this->denyAccessUnlessGranted('edit', $plan);

        $em = $this->getDoctrine()->getManager();


        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $plan = $em->getRepository('App:Plan')->findOneByAnio(2021, $academico);

        $enviado = $plan->isEnviado();

        $deleteForm = $this->createDeleteForm($plan);
        $editForm = $this->createForm('App\Form\PlanType', $plan);
//        $this->denyAccessUnlessGranted('edit', $plan);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_edit', array('id' => $plan->getId()));
        }

        return $this->render('plan/edit.html.twig', array(
            'plan' => $plan,
            'enviado'=> $enviado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Plan entity.
     *
     * @Route("/{id}", name="plan_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Plan $plan)
    {
        $form = $this->createDeleteForm($plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plan);
            $em->flush();
        }

        return $this->redirectToRoute('plan_index');
    }

    /**
     * Creates a form to delete a Plan entity.
     *
     * @param Plan $plan The Plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('id' => $plan->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}