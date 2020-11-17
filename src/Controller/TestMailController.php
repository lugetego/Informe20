<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestMailController extends AbstractController
{
    /**
     * @Route("/test/mail", name="test_mail")
     */
    public function index(Request $request, \Swift_Mailer $mailer,
                          LoggerInterface $logger)
    {
        $name = $request->query->get('name');

        $message = new \Swift_Message('Test email');
        $message->setFrom('gerardo@matmor.unam.mx');
        $message->setTo('gerardo@matmor.unam.mx');
        $message->setBody(
            $this->renderView(
                'mail/myemail.html.twig',
                ['name' => $name]
            ),
            'text/html'
        );

        $mailer->send($message);

        $logger->info('email sent');
        $this->addFlash('notice', 'Email sent');

        return $this->redirectToRoute('test_mail');
    }
}
