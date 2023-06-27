<?php

namespace App\Controller;

use App\Entity\Inquiry;
use App\Form\Type\InquiryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'fe_index')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true)]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        TransportInterface $mailer,
        TranslatorInterface $translator
    ): Response {
        $inquiry = new Inquiry();
        $form = $this->createForm(InquiryType::class, $inquiry);
        $form->handleRequest($request);
        // sendCopyToReceiver is the honeypot field, so it must be null.
        if ($form->isSubmitted() && $form->isValid() && is_null($form->get('sendCopyToReceiver')->getData())) {
            // Persist inquiry.
            $entityManager->persist($inquiry);
            $entityManager->flush();
            // Send email to admin.
            $email = (new TemplatedEmail())
                ->from('wolf@utz-it.de')
                ->to('wolf@utz-it.de')
                ->subject('Neue Kontaktanfrage')
                ->htmlTemplate('emails/contact.html.twig')
                ->context(['inquiry' => $inquiry]);
            $mailer->send($email);

            $this->addFlash('success', $translator->trans('form.submitSuccessful'));
            return $this->redirect($this->generateUrl('fe_index').'#contact');
        }

        return $this->render('index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/impressum', name: 'fe_impressum')]
    public function impressum(): Response
    {
        return $this->render('impressum.html.twig');
    }

    #[Route('/datenschutz', name: 'fe_datenschutz')]
    public function datenschutz(): Response
    {
        return $this->render('datenschutz.html.twig');
    }
}