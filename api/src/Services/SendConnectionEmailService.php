<?php

namespace App\Services;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

final class SendConnectionEmailService
{
    public function __construct(
        private string $defaultAdmin,
        private EntityManagerInterface $em,
        private LoginLinkHandlerInterface $loginLinkHandler,
        private MemberRepository $memberRepository,
        private NotifierInterface $notifier,
    ) {
    }

    /**
     * @param string $email
     * @return string
     */
    public function send(string $email, string $requiredRole = 'ROLE_ADMIN'): ?string
    {
        $member = $this->memberRepository->findOneBy(["email" => $email]);

        if (!$member && $email === $this->defaultAdmin) {
            $member = $this->generateDefaultAdminMember();
        }

        if (!$member || !in_array($requiredRole, $member->getRoles(), true)) {
            return null;
        }

        $loginLinkDetails = $this->loginLinkHandler->createLoginLink($member);

        $notification = new LoginLinkNotification(
            $loginLinkDetails,
            'Enlace de conexión a PlayRoom'
        );
        $recipient = new Recipient($email);

        $this->notifier->send($notification, $recipient);

        return $loginLinkDetails->getUrl();
    }

    private function generateDefaultAdminMember(): Member
    {
        $member = new Member();
        $member->setEmail($this->defaultAdmin)
            ->setAlias("admin")
            ->setRoles(["ROLE_ADMIN"]);

        $this->em->persist($member);
        $this->em->flush();

        return $member;
    }
}
