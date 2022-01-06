<?php

declare(strict_types=1);

namespace App\Security;

use App\Message\Member\RegisterMemberMessage;
use App\Repository\MemberRepository;
use Symfony\Component\Messenger\MessageBusInterface;

final class NextAuthUserLoader
{
    public function __construct(
        private MemberRepository $memberRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(string $userIdentifier)
    {
        $this->messageBus->dispatch(
            new RegisterMemberMessage($userIdentifier)
        );

        return $this->memberRepository->findOneBy(['email' => $userIdentifier]);
    }
}
