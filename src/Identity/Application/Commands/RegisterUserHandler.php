<?php

declare(strict_types=1);

namespace RunTracker\Identity\Application\Commands;

use RunTracker\Identity\Domain\Model\UserEmail;
use RunTracker\Identity\Domain\Ports\UserFactoryInterface;
use RunTracker\Identity\Domain\Ports\UserRepositoryInterface;

class RegisterUserHandler
{
    public function __construct(
        private readonly UserFactoryInterface $userFactory,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = $this->userFactory->create(
            new UserEmail($command->email),
            $command->plainPassword
        );

        $this->userRepository->add($user);
    }
}
