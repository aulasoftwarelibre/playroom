<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class NextAuthAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private NextAuthCookieDecrypt $nextAuthCookieDecrypt,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->cookies->has('__Secure-next-auth_session-token');
    }

    public function authenticate(Request $request): Passport
    {
        $jweToken = $request->cookies->get('__Secure-next-auth_session-token');

        if (null === $jweToken) {
            throw new CustomUserMessageAuthenticationException("No API token provider");
        }

        $credentials = $this->nextAuthCookieDecrypt->decrypt($jweToken);

        if (!array_key_exists('email', $credentials)) {
            throw new CustomUserMessageAuthenticationException("Invalid token. Missing email attribute.");
        }

        return new SelfValidatingPassport(new UserBadge($credentials["email"]));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
