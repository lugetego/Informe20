<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Informe;
use App\Entity\User;
use App\Entity\Plan;
use App\Entity\Academico;


/**
 * Dash controller.
 *
 * @Route("/dash")
 */
class DashController extends AbstractController

{

    /**
     * Lists all actions on Informe .
     *
     * @Route("/{actual}", name="dashboard", methods={"GET"}, defaults={"actual"="2020"})
     */

    public function indexAction($actual)
    {
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ( $this->isGranted('ROLE_ADMIN') )
        {
            $informes = $em->getRepository('App:Informe')->findByActivo($actual);
            return $this->render('dash/admin.html.twig', array(
                'informes'=> $informes,
            ));
        }

        elseif ( $this->isGranted('ROLE_TECNICO'))
        {
            $user = $this->getUser();
            $academico = $user->getAcademico();
            $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $academico);
            $enviado = $informe->isEnviado();
            $tecnicos = $em->getRepository('App:Tecnico')->findOneByInforme($informe);
            return $this->render('dash/tecnico.html.twig', array(
                'informe'=>$informe,
                'academico'=>$academico,
                'tecnicos'=> $tecnicos,
                'enviado'=>$enviado,
                'user'=>$user,

            ));
        }

        else {
            $user = $this->getUser();
            $academico = $user->getAcademico();

            $informe = $em->getRepository('App:Informe')->findOneByAnio($actual, $academico);
            $plan = $em->getRepository('App:Plan')->findOneByAnio(2021,$academico);

            $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());
            $visitas = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());

            return $this->render('dash/index.html.twig', array(
                'informe' => $informe,
                'academico' => $academico,
                'plan' => $plan,
                'eventos' => $eventos,
                'visitas' => $visitas,

            ));
        }
    }

    /**
     * Lists all actions on Informe .
     *
     * @Route("/consulta/{anio}", name="consulta", methods={"GET"})
     */
    public function consultaAction(Informe $informe)
    {
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ( $this->isGranted('ROLE_ADMIN') )
        {
            $academicos = $em->getRepository('InformeBundle:Academico')->findAll();
            return $this->render('dash/admin.html.twig', array(
                'academicos'=> $academicos,
            ));
        }

        elseif ( $this->isGranted('ROLE_TECNICO'))
        {
            $user = $this->getUser();
            $academico = $user->getAcademico();
            $informe = $em->getRepository('App:Informe')->findOneByAnio($informe->getAnio(),$academico);
            $tecnicos = $em->getRepository('App:Tecnico')->findOneByInforme($informe);
            $informeAnual = $tecnicos->getInformeAnual();
            $plan= $tecnicos->getPlan();
            $enviado = $informe->isEnviado();

            return $this->render('dash/consulta-tecnico.html.twig', array(
                'academico'=>$academico,
                'tecnicos'=> $tecnicos,
                'plan'=> $plan,
                'enviado'=>$enviado,
                'informe'=> $informe,
                'informeAnual'=>$informeAnual,
                'user'=>$user,

            ));
        }

        else {
            $user = $this->getUser();
            $academico = $user->getAcademico();

            $informe = $em->getRepository('App:Informe')->findOneByAnio($informe->getAnio(),$academico);
            $plan = $em->getRepository('App:Plan')->findOneByAnio($informe->getAnio()+1,$academico);

            $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());
            $visitas = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());

            return $this->render('dash/consulta.html.twig', array(
                'informe' => $informe,
                'academico' => $academico,
                'plan' => $plan,
                'eventos' => $eventos,
                'visitas' => $visitas,

            ));



        }

    }

    /**
     * Export to PDF
     *
     * @Route("/pdf/{anio}", name="informe_pdf")
     */
    public function pdfAction(Informe $informe, \Knp\Snappy\Pdf $knpSnappy)
    {
        $this->knpSnappy = $knpSnappy;

        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $academico = $user->getAcademico();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($informe->getAnio(),$academico);
        $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());
        $visitas = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());




        $html = $this->renderView('dash/layout-pdf.html.twig', array(
            'academico'=>$academico,
            'informe'=>$informe,
            'eventos'=>$eventos,
            'visitas'=>$visitas,

        ));

        $filename = sprintf('Informe-'.$user.'%s.pdf', $informe->getAnio());

        $pdfOptions = array(
            'footer-right'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
        );
        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );
    }

    /**
     * Export to PDF
     *
     * @Route("/pdfplan/{anio}", name="plan_pdf")
     */
    public function pdfPlanAction(Plan $plan, \Knp\Snappy\Pdf $knpSnappy)
    {
        $this->knpSnappy = $knpSnappy;

        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $academico = $user->getAcademico();
        $plan = $em->getRepository('App:Plan')->findOneByAnio($plan->getAnio(), $academico);

        $html = $this->renderView('dash/layout-pdfplan.html.twig', array(
            'academico'=>$academico,
            'plan'=>$plan,
        ));

        $filename = sprintf('Plan-'.$user.'%s.pdf', $plan->getAnio());
        $pdfOptions = array(
            'footer-right'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
        );

        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );
    }

    /**
     * Export to PDF
     *
     * @Route("/pdftecnico/{anio}", name="informe_pdftecnico")
     */
    public function pdfTecnicoAction(Informe $informe, \Knp\Snappy\Pdf $knpSnappy)
    {
        $this->knpSnappy = $knpSnappy;

        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $academico = $user->getAcademico();
        $informe = $em->getRepository('App:Informe')->findOneByAnio($informe->getAnio(),$academico);
        $tecnicos = $em->getRepository('App:Tecnico')->findOneByInforme($informe);
        $informeAnual=$tecnicos->getInformeAnual();
        $plan=$tecnicos->getPlan();

        $html = $this->renderView('dash/layout-pdftecnico.html.twig', array(
            'informe'=>$informe,
            'informeAnual'=>$informeAnual,
            'plan'=>$plan,
            'academico'=>$academico,
            'tecnicos'=>$tecnicos,
        ));

        $filename = sprintf('Informe-'.$user.'%s.pdf', date('Y-m-d'));

        $pdfOptions = array(
            'footer-right'     => ('Hoja [page] de [toPage]'),
            'footer-font-size'=> 8,
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
        );

        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );
    }

    /**
     * Export to PDF admin
     *
     * @Route("/pdfadmin/{id}", name="informe_pdfadmin")
     */
    public function pdfAdminAction(Academico $academico, \Knp\Snappy\Pdf $knpSnappy)
    {

        $this->knpSnappy = $knpSnappy;
        $em = $this->getDoctrine()->getManager();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        if ($this->isGranted('ROLE_ADMIN')) {

            $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
            $eventos = $em->getRepository('App:Eventos')->findEventos($informe->getId());
            $visitas = $em->getRepository('App:Eventos')->findByVisitantes($informe->getId());
            $plan = $em->getRepository('App:Plan')->findOneByAnio(2021, $academico);


            if(in_array('ROLE_TECNICO', $academico->getUser()->getRoles())){

                $tecnicos = $em->getRepository('App:Tecnico')->findOneByInforme($informe);
                $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
                $informeAnual = $tecnicos->getInformeAnual();
                $plan= $tecnicos->getPlan();

                $html = $this->renderView('dash/layout-pdftecnico.html.twig', array(
                    'academico' => $academico,
                    'tecnicos' => $tecnicos,
                    'informe'=>$informe,
                    'plan' => $plan,
                    'informeAnual'=>$informeAnual,
                ));
            }
            else {
                $html = $this->renderView('dash/layout-pdf.html.twig', array(
                    'academico'=>$academico,
                    'eventos'=>$eventos,
                    'visitas'=>$visitas,
                    'informe'=>$informe,
                    'plan'=>$plan,

                ));
            }

            $filename = sprintf('Informe-'.$academico->getUser().'%s.pdf', date('Y-m-d'));

            $pdfOptions = array(
                'footer-right'     => ('Hoja [page] de [toPage]'),
                'footer-font-size'=> 8,
                'margin-top'    => 10,
                'margin-right'  => 10,
                'margin-bottom' => 10,
                'margin-left'   => 10,
            );
        }

        return new Response(
            $this->knpSnappy->getOutputFromHtml($html, $pdfOptions),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),

            ]
        );

    }

    /**
     * Envío informe y plan
     *
     * @Route("/send", name="informe_send", methods={"GET","POST"})

     */

    public function send(Request $request, \Swift_Mailer $mailer): Response

    {

        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $academico = $user->getAcademico();

        $informe = $em->getRepository('App:Informe')->findOneByAnio(2020, $academico);
        $plan = $em->getRepository('App:Plan')->findOneByAnio(2021, $academico);
        $informe->setEnviado(true);
        $plan->setEnviado(true);
        $em->persist($informe);
        $em->persist($plan);
        $em->flush();

        // Correos electrónicos
        $message = (new \Swift_Message('Informe y plan de trabajo'))
            ->setFrom('webmaster@matmor.unam.mx')
            ->setTo(array($user->getEmail() ))
//            ->setTo('gerardo@matmor.unam.mx')
            ->setBcc(array('webmaster@matmor.unam.mx','vorozco@matmor.unam.mx'))
            ->setBody($this->renderView('dash/mail.txt.twig', array('entity' => $informe,'academico'=>$academico)));

        ;
        $mailer->send($message);
        return $this->redirectToRoute('dashboard');

    }

}