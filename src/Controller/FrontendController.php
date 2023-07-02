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
    #[Cache(maxage: 3600, public: true, mustRevalidate: true)]
    public function index(
        Request                $request,
        EntityManagerInterface $entityManager,
        TransportInterface     $mailer,
        TranslatorInterface    $translator
    ): Response
    {
        $services = [
            [
                'name' => 'page.services.shopware',
                'image' => '/assets/img/services/shopware.png',
                'keywords' => [
                    'page.services.keywords.e-commerce',
                    'page.services.keywords.cms'
                ]
            ],
            [
                'name' => 'page.services.typo3',
                'image' => '/assets/img/services/typo3.svg',
                'keywords' => [
                    'page.services.keywords.cms'
                ]
            ],
            [
                'name' => 'page.services.wordPress',
                'image' => '/assets/img/services/wordpress.svg',
                'keywords' => [
                    'page.services.keywords.blog',
                    'page.services.keywords.cms',
                ]
            ],
            [
                'name' => 'page.services.symfony',
                'image' => '/assets/img/services/symfony.svg',
                'keywords' => [
                    'page.services.keywords.webApp',
                    'page.services.keywords.api',
                    'page.services.keywords.cli',
                ]
            ],
            [
                'name' => 'page.services.spring',
                'image' => '/assets/img/services/spring.svg',
                'keywords' => [
                    'page.services.keywords.webApp',
                    'page.services.keywords.api',
                    'page.services.keywords.cli',
                ]
            ],
            [
                'name' => 'page.services.vue',
                'image' => '/assets/img/services/vuejs.svg',
                'keywords' => [
                    'page.services.keywords.webApp',
                ]
            ]
        ];
        $skills = [
            [
                'name' => 'page.skills.php',
                'image' => '/assets/img/skills/php.svg',
            ],
            [
                'name' => 'page.skills.java',
                'image' => '/assets/img/skills/java.svg',
            ],
            [
                'name' => 'page.skills.csharp',
                'image' => '/assets/img/skills/csharp.svg',
            ],
            [
                'name' => 'page.skills.javascript',
                'image' => '/assets/img/skills/javascript.svg',
            ],
            [
                'name' => 'page.skills.css',
                'image' => '/assets/img/skills/css.svg',
            ],
            [
                'name' => 'page.skills.html',
                'image' => '/assets/img/skills/html.svg',
            ],
        ];

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
            return $this->redirect($this->generateUrl('fe_index') . '#contact');
        }

        return $this->render('index.html.twig', ['form' => $form, 'services' => $services, 'skills' => $skills])
            ->setMaxAge(3600)
            ->setPublic();
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