<?php


namespace App\Controller;

use App\Entity\Productividad;
use App\Entity\Academico;
use App\Entity\User;
use App\Form\ProductividadType;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//use App\Security\InvesVoter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Productividad controller.
 *
 * @Route("/productividad")
 */

class ProductividadController extends AbstractController

{
    /**
     * Lists all Productividad entities.
     * @Route("/anual/{actual}", name="productividad_index", methods={"GET"}, defaults={"actual"="2020"})

     */
    public function indexAction($actual)
    {
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $user->getAcademico());
        $productividades = $informe->getProductividades();
        $enviado = $informe->isEnviado();


        return $this->render('productividad/index.html.twig', array(
            'productividades' => $productividades,
            'enviado'=>$enviado,
            'anual'=>$actual,
        ));
    }

    /**
     * Creates a new Productividad entity.
     *
     * @Route("/new", name="productividad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);

        $productividad = new Productividad();
        $form = $this->createForm('App\Form\ProductividadType', $productividad, array('user'=>$user));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $productividad->setInforme($informe);
            $em->persist($productividad);
            $em->flush();

            return $this->redirectToRoute('productividad_index');
            // return $this->redirectToRoute('dashboard');
        }

        return $this->render('productividad/new.html.twig', array(
            'productividad' => $productividad,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a Productividad entity.
     * @Route("/{id}", name="productividad_show", methods={"GET"})
     */
    public function show(Productividad $productividad): Response
    {

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $em = $this->getDoctrine()->getManager();
        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $enviado = $informe->isEnviado();

        $deleteForm = $this->createDeleteForm($productividad);

        // check for "view" access: calls all voters
//        $this->denyAccessUnlessGranted('view', $productividad);

        return $this->render('productividad/show.html.twig', array(
            'productividad' => $productividad,
            'enviado'=>$enviado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Productividad entity.
     *
     * @Route("/{id}/edit", name="productividad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Productividad $productividad): Response
    {
        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->container->get('security.token_storage');
        $user = $securityContext->getToken()->getUser();
        $academico = $user->getAcademico();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $deleteForm = $this->createDeleteForm($productividad);
//        $this->denyAccessUnlessGranted('edit', $productividad);
        $editForm = $this->createForm('App\Form\ProductividadType', $productividad, array('user'=>$user));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productividad);
            $em->flush();

            //return $this->redirectToRoute('investigacion_show', array('id' => $investigacion->getId()));

            return $this->redirectToRoute('productividad_index');

        }

        return $this->render('productividad/edit.html.twig', array(
            'id'=>$productividad->getId(),
            'productividad' => $productividad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Productividad entity.
     *
     * @Route("/{id}", name="productividad_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Productividad $productividad)
    {
        $form = $this->createDeleteForm($productividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productividad);
            $em->flush();
        }

        return $this->redirectToRoute('productividad_index');
    }

    /**
     * Creates a form to delete a Productividad entity.
     *
     * @param Productividad $productividad The Productividad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Productividad $productividad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productividad_delete', array('id' => $productividad->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}