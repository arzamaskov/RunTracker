<?php

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Identity\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use RunTracker\Identity\Application\Commands\RegisterUserCommand;
use RunTracker\Identity\Application\Commands\RegisterUserHandler;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends Controller
{
    public function __construct(
        private readonly RegisterUserHandler $handler
    ) {}

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $command = new RegisterUserCommand(
            $request->email,
            $request->name,
            $request->password
        );
        ($this->handler)($command);

        return response()->json(['message' => 'User registered successfully'], Response::HTTP_CREATED);
    }
}
