<?php

namespace App\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\QueryItemResolverInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

final class GetMeResolver implements QueryItemResolverInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    /**
     * @return UserInterface|null
     */
    public function __invoke($item, array $context)
    {
        return $this->security->getUser();
    }
}
