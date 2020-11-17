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
 * Eventos controller.
 *
 * @Route("/eventos")
 */
class EventosController extends AbstractController
{
    /**
     * Lists all Eventos entities.
     *
     * @Route("/", name="eventos_index", methods={"GET"})
     * @Route("/anual/{actual}", name="eventos_index", methods={"GET"}, defaults={"actual"="2020"})

     */
    public function index($actual)
    {

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());

        $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());

        $enviado = $informe->isEnviado();

        return $this->render('eventos/index.html.twig', array(
            'eventos' => $eventos,
            'enviado'=>$enviado,
            'titulo' => 'Licencias, comisiones',
            'anual'=>$actual,
        ));
    }

//    /**
//     * Lists all Eventos entities.
//     *
//     * @Route("/visitas", name="visitas_index")
//     * @Method("GET")
//     */
//    public function visitasAction()
//    {
//
//        $em = $this->getDoctrine()->getManager();
//
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            throw $this->createAccessDeniedException();
//        }
//
//        $user = $this->get('security.context')->getToken()->getUser();
//        $informe = $em->getRepository('App:Informe')->findOneByAnio(2018, $user->getAcademico());
//
//        $visitantes = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());
//
//        $enviado = $informe->isEnviado();
//
//
//        return $this->render('eventos/index.html.twig', array(
//            'eventos' => $visitantes,
//            'enviado'=>$enviado,
//            'titulo' => 'Visitantes',
//        ));
//
//    }

    /**
     * Creates a new Eventos entity.
     *
     * @Route("/new", name="eventos_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $evento = new Eventos();
        $form = $this->createForm('App\Form\EventosType', $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evento->setInforme($informe);
            $em->persist($evento);
            $em->flush();

            if ($evento->getTipo() == 'Visitante') {
//                return $this->redirectToRoute('visitas_index');
            }
            else {
                //return $this->redirectToRoute('eventos_show', array('id' => $evento->getId()));
                return $this->redirectToRoute('eventos_index');
            }

        }

        return $this->render('eventos/new.html.twig', array(
            'evento' => $evento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Eventos entity.
     *
     * @Route("/{id}", name="eventos_show", methods={"GET"})
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


        return $this->render('eventos/show.html.twig', array(
            'evento' => $evento,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Eventos entity.
     *
     * @Route("/{id}/edit", name="eventos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Eventos $evento)
    {
        $deleteForm = $this->createDeleteForm($evento);
//        $this->denyAccessUnlessGranted('edit', $evento);
        $editForm = $this->createForm('App\Form\EventosType', $evento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);
            $em->flush();

            if ($evento->getTipo() == 'Visitante') {
                return $this->redirectToRoute('visitas_index');
            }
            else {
                //return $this->redirectToRoute('eventos_show', array('id' => $evento->getId()));
                return $this->redirectToRoute('eventos_index');
            }

        }

        return $this->render('eventos/edit.html.twig', array(
            'id'=>$evento->getId(),
            'evento' => $evento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Eventos entity.
     *
     * @Route("/{id}", name="eventos_delete", methods={"DELETE"})
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

        return $this->redirectToRoute('eventos_index');
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
            ->setAction($this->generateUrl('eventos_delete', array('id' => $evento->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}