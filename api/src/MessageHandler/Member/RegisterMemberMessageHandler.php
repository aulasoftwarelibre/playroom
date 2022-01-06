<?php

declare(strict_types=1);

namespace App\MessageHandler\Member;

use App\Entity\Member;
use App\Message\Member\RegisterMemberMessage;
use App\Repository\MemberRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RegisterMemberMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private MemberRepository $memberRepository,
    ) {
    }

    public function __invoke(RegisterMemberMessage $message): void
    {
        $userIdentifier = $message->userIdentifier;

        if ($this->memberRepository->findOneBy(['email' => $userIdentifier])) {
            return;
        }

        $member = (new Member())
            ->setEmail($userIdentifier);

        $this->memberRepository->add($member);
    }
}
