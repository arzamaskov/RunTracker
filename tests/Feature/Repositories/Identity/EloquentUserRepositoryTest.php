<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories\Identity;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use RunTracker\Identity\Domain\Factory\UserFactory;
use RunTracker\Identity\Domain\ValueObject\UserId;
use RunTracker\Identity\Infrastructure\Repositories\Identity\EloquentUserRepository;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var EloquentUserRepository $repository */
        $this->repository = $this->app->make(EloquentUserRepository::class);
        /** @var UserFactory $factory */
        $this->factory = $this->app->make(UserFactory::class);
    }

    public function test_it_adds_user_to_database(): void
    {
        $email = $this->faker->unique()->safeEmail();
        $hashedPassword = Hash::make($this->faker->password());

        $user = $this->factory->create($email, $hashedPassword);

        $this->repository->add($user);

        $this->assertDatabaseHas(new User()->getTable(), [
            'id' => $user->id()->value(),
            'email' => $email,
        ]);

        $savedUser = User::query()->find($user->id()->value());
        self::assertNotNull($savedUser);
        self::assertSame($hashedPassword, $savedUser->password);
    }

    public function test_user_found_by_id_successfully(): void
    {
        // arrange
        $eloquentUser = User::factory()->create();
        $eloquentUser->save();
        $userId = UserId::new($eloquentUser->id);

        // act
        $user = $this->repository->find($userId);

        // assert
        self::assertEquals($eloquentUser->id, $user->id()->value());
    }
}
