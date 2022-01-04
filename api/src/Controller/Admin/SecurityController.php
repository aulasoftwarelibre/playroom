<?php

namespace App\Controller\Admin;

use App\Repository\MemberRepository;
use App\Services\SendConnectionEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

final class SecurityController extends AbstractController
{
    #[Route('/admin/login', name: 'login')]
    public function login(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        SendConnectionEmailService $sendConnectionEmailService,
    ): \Symfony\Component\HttpFoundation\Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $sendConnectionEmailService->send($email);

            $this->addFlash('success', 'Revisa tu correo electrónico, si tu dirección está registrada recibirás un enlace de conexión');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('/security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'page_title' => 'Iniciar sesión',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('dashboard'),
            'username_label' => 'Dirección de correo',
            'username_parameter' => 'email',
        ]);
    }

    /**
     * @return never
     */
    #[Route('/admin/login_check', name: 'login_check')]
    public function check()
    {
        throw new \LogicException('This code should never be reached.');
    }

    /**
     * @return never
     */
    #[Route('/admin/logout', name: 'logout')]
    public function logout()
    {
        throw new \LogicException('This code should never be reached.');
    }
}
