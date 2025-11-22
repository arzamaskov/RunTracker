<?php

declare(strict_types=1);

namespace RunTracker\Identity\Application\Command\CreateUser;

use RunTracker\Identity\Application\Port\PasswordHasher;
use RunTracker\Identity\Domain\Factory\UserFactory;
use RunTracker\Identity\Domain\Port\UserRepository;
use RunTracker\Identity\Domain\ValueObject\UserId;
use RunTracker\Shared\Application\Command\Command;
use RunTracker\Shared\Application\Command\CommandHandler as CommandHandlerInterface;

readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserFactory $userFactory,
        private PasswordHasher $passwordHasher,
    ) {}

    /**
     * @param  CreateUserCommand  $command
     */
    public function handle(Command $command): UserId
    {
        $hashedPassword = $this->passwordHasher->hash($command->password);
        $user = $this->userFactory->create($command->email, $hashedPassword);
        $this->userRepository->add($user);

        return $user->id();
    }
}
