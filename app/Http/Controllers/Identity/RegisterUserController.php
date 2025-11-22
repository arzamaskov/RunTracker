<?php

namespace App\Http\Controllers\Identity;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\RedirectResponse;
use RunTracker\Identity\Application\Command\CreateUser\CreateUserCommand;
use RunTracker\Shared\Application\Command\CommandBus;

class RegisterUserController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus) {}

    public function __invoke(RegisterUserRequest $request): RedirectResponse
    {
        $command = new CreateUserCommand($request->email, $request->password);
        $this->commandBus->execute($command);

        return redirect()->route('login')->with('success', 'Регистрация успешна. Войдите в систему.');
    }
}
