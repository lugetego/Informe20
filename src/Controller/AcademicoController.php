<?php

namespace App\Controller;

use App\Entity\Academico;
use App\Form\AcademicoType;
use App\Repository\AcademicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/academico")
 */
class AcademicoController extends AbstractController
{
    /**
     * @Route("/", name="academico_index", methods={"GET"})
     */
    public function index(AcademicoRepository $academicoRepository): Response
    {
        return $this->render('academico/index.html.twig', [
            'academicos' => $academicoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="academico_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $academico = new Academico();
        $form = $this->createForm(AcademicoType::class, $academico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($academico);
            $entityManager->flush();

            return $this->redirectToRoute('academico_index');
        }

        return $this->render('academico/new.html.twig', [
            'academico' => $academico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academico_show", methods={"GET"})
     */
    public function show(Academico $academico): Response
    {
        return $this->render('academico/show.html.twig', [
            'academico' => $academico,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="academico_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Academico $academico): Response
    {
        $form = $this->createForm(AcademicoType::class, $academico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academico_index');
        }

        return $this->render('academico/edit.html.twig', [
            'academico' => $academico,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academico_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Academico $academico): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academico->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($academico);
            $entityManager->flush();
        }

        return $this->redirectToRoute('academico_index');
    }
}
