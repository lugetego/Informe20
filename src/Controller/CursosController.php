<?php

namespace App\Controller;

use App\Entity\Cursos;
use App\Form\CursosType;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cursos")
 */
class CursosController extends AbstractController
{
    /**
     * @Route("/anual/{actual}", name="cursos_index", methods={"GET"}, defaults={"actual"="2020"})
     */
    public function index($actual)
    {

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $cursos = $informe->getCursos();
        $enviado = $informe->isEnviado();


        return $this->render('cursos/index.html.twig', array(
            'cursos' => $cursos,
            'enviado'=>$enviado,
            'anual'=>$actual,
        ));
    }

    /**
     * Creates a new Cursos entity.
     *
     * @Route("/new", name="cursos_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $securityContext = $this->container->get('security.token_storage');

        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $curso = new Cursos();
        $form = $this->createForm('App\Form\CursosType', $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $curso->setInforme($informe);
            $em->persist($curso);
            $em->flush();

            //return $this->redirectToRoute('cursos_show', array('id' => $curso->getId()));
            return $this->redirectToRoute('cursos_index');

        }

        return $this->render('cursos/new.html.twig', array(
            'curso' => $curso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cursos entity.
     *
     * @Route("/{id}", name="cursos_show", methods={"GET"})
     */
    public function show(Cursos $curso)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $enviado = $informe->isEnviado();

        $deleteForm = $this->createDeleteForm($curso);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $curso);


        return $this->render('cursos/show.html.twig', array(
            'curso' => $curso,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cursos entity.
     *
     * @Route("/{id}/edit", name="cursos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cursos $curso)
    {

        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $deleteForm = $this->createDeleteForm($curso);

//        $this->denyAccessUnlessGranted('edit', $curso);

        $editForm = $this->createForm('App\Form\CursosType', $curso);

        $editForm->remove('lugares');
        $editForm->remove('lugar');


        $editForm->add('lugar','Symfony\Component\Form\Extension\Core\Type\TextType', array('label' => 'Lugar donde se impartió'));


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();

            //return $this->redirectToRoute('cursos_edit', array('id' => $curso->getId()));
            return $this->redirectToRoute('cursos_index');

        }

        return $this->render('cursos/edit.html.twig', array(
            'id'=>$curso->getId(),
            'curso' => $curso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cursos entity.
     *
     * @Route("/{id}", name="cursos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cursos $curso)
    {
        $form = $this->createDeleteForm($curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($curso);
            $em->flush();
        }

        return $this->redirectToRoute('cursos_index');
    }

    /**
     * Creates a form to delete a Cursos entity.
     *
     * @param Cursos $curso The Cursos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cursos $curso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cursos_delete', array('id' => $curso->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}