<?php

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RunTracker\Identity\Application\Commands\RegisterUserCommand;
use RunTracker\Identity\Application\Commands\RegisterUserHandler;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends Controller
{
    public function __construct(
        private readonly RegisterUserHandler $handler
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request::validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        $command = new RegisterUserCommand($validated['email'], $validated['password']);
        ($this->handler)($command);

        return response()->json(['message' => 'User registered successfully'], Response::HTTP_CREATED);
    }
}
