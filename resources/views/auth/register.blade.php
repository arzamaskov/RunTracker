@extends('layouts.auth')

@section('title', 'Регистрация в RunTracker')
@section('heading', 'Создайте новый аккаунт')

@section('content')
    <form class="space-y-6" action="{{ route('register.store') }}" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Email</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required
                       class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Пароль</label>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                       class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-slate-900">Подтверждение
                пароля</label>
            <div class="mt-2">
                <input id="password_confirmation" name="password_confirmation" type="password"
                       autocomplete="new-password"
                       required
                       class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Зарегистрироваться
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-slate-500">
        Уже есть аккаунт?
        <a href="{{ route('login') }}" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Войти</a>
    </p>
@endsection
