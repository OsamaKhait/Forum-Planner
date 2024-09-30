<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private GoogleAuthenticatorInterface $googleAuthenticator;
    private EntityManagerInterface $entityManager;

    public function __construct(GoogleAuthenticatorInterface $googleAuthenticator, EntityManagerInterface $entityManager)
    {
        $this->googleAuthenticator = $googleAuthenticator;
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

//    #[Route('/enable2FA', name: 'app_2fa_setup')]
//    public function setup2FA(Request $request): Response
//    {
//        /** @var User $user */
//        $user = $this->getUser();
//
//        // Generate a secret if the user doesn't have one
//        if (!$user->getGoogleAuthenticatorSecret()) {
//            $secret = $this->googleAuthenticator->generateSecret();
//            $user->setGoogleAuthenticatorSecret($secret);
//            $this->entityManager->persist($user);
//            $this->entityManager->flush();
//        }
//
//        // Generate the QR code
//        $qrCode = Builder::create()
//            ->writer(new PngWriter())
//            ->data($this->googleAuthenticator->getQRContent($user))
//            ->encoding(new Encoding('UTF-8'))
//            ->errorCorrectionLevel(new ErrorCorrectionLevel\High())
//            ->size(300)
//            ->margin(10)
//            ->roundBlockSizeMode(new RoundBlockSizeMode\Margin())
//            ->build();
//
//        // Convert QR code to data URL for embedding in HTML
//        $qrCodeDataUri = $qrCode->getDataUri();
//
//        // Handle form submission and verify 2FA code
//        if ($request->isMethod('POST')) {
//            $code = $request->request->get('auth_code');
//            if ($this->googleAuthenticator->checkCode($user, $code)) {
//                // Code is correct, enable 2FA
//                $user->setTwoFactorEnabled(true);
//                $this->entityManager->persist($user);
//                $this->entityManager->flush();
//
//                $this->addFlash('success', '2FA activée avec succès!');
//                return $this->redirectToRoute('app_profile');
//            } else {
//                // Invalid code, show an error
//                $this->addFlash('error', 'Le code est incorrect, veuillez réessayer.');
//            }
//        }
//
//        // Pass the QR code URL to the template
//        return $this->render('security/2fa_setup.html.twig', [
//            'qrCodeUrl' => $qrCodeDataUri,  // Ensure this line is present
//        ]);
//
//    }


}
