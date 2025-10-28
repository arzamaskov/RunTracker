<?php

namespace Tests\Unit\Identity\Application\Commands;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RunTracker\Identity\Application\Commands\RegisterUserCommand;
use RunTracker\Identity\Application\Commands\RegisterUserHandler;
use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Model\UserEmail;
use RunTracker\Identity\Domain\Model\UserId;
use RunTracker\Identity\Domain\Ports\UserFactoryInterface;
use RunTracker\Identity\Domain\Ports\UserRepositoryInterface;

class RegisterUserHandlerTest extends TestCase
{
    private UserFactoryInterface|MockObject $userFactory;

    private UserRepositoryInterface|MockObject $userRepository;

    private RegisterUserHandler $handler;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userFactory = $this->createMock(UserFactoryInterface::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->handler = new RegisterUserHandler(
            $this->userFactory,
            $this->userRepository
        );
    }

    /**
     * @throws Exception
     */
    public function test_it_creates_and_adds_user(): void
    {
        // arrange
        $command = new RegisterUserCommand(
            'test@test.com',
            'Test User',
            'password'
        );
        $user = new User(new UserId, new UserEmail($command->email), 'Test User', 'hashed_password');
        $this->userFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                new UserEmail($command->email),
                $command->name,
                $command->plainPassword
            )
            ->willReturn($user);

        $this->userRepository
            ->expects($this->once())
            ->method('add')
            ->with(self::identicalTo($user));

        // act
        ($this->handler)($command);
    }
}
