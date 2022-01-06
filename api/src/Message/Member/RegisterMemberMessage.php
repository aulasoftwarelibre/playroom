<?php

declare(strict_types=1);

namespace App\Message\Member;

final class RegisterMemberMessage
{
    public function __construct(public readonly string $userIdentifier)
    {
    }
}
