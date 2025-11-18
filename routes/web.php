<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('health-check', function () {
    return new JsonResponse(
        ['status' => 'OK']
    );
});
