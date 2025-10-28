<?php

namespace Tests\Unit\Identity\Domain\Model;

use PHPUnit\Framework\TestCase;
use RunTracker\Identity\Domain\Events\UserWasCreated;
use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Model\UserEmail;
use RunTracker\Identity\Domain\Model\UserId;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_user_creation_records_event(): void
    {
        // arrange
        $id = new UserId;
        $email = new UserEmail('test@test.com');

        // act
        $user = $this->createUser($id, $email);

        // assert
        $events = $user->pullDomainEvents();

        self::assertCount(1, $events);
        self::assertInstanceOf(UserWasCreated::class, $events[0]);

        $event = reset($events);
        self::assertEquals($id->toString(), $event->userId->toString());
        self::assertEquals($email->userEmail, $event->email->userEmail);
    }

    public function test_password_can_be_changed(): void
    {
        // arrange
        $user = $this->createUser();

        // act
        $newPassword = 'new_password';
        $user->changePassword($newPassword);

        // assert
        self::assertEquals($newPassword, $user->password());
    }

    public function test_email_can_be_changed(): void
    {
        // arrange
        $user = $this->createUser();

        // act
        $newEmail = new UserEmail('new@test.com');
        $user->changeEmail($newEmail);

        // assert
        self::assertEquals($newEmail, $user->email());
    }

    private function createUser(
        ?UserId $id = null,
        ?UserEmail $email = null,
        ?string $name = 'Test User',
        string $password = 'password'
    ): User {
        return new User(
            $id ?? new UserId,
            $email ?? new UserEmail('default@test.com'),
            $name,
            $password
        );
    }
}
