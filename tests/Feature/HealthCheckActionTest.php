<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HealthCheckActionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @throws \Throwable
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/health-check');

        $response->assertStatus(Response::HTTP_OK);
        $responseJson = $response->decodeResponseJson();
        self::assertEquals('OK', $responseJson->json('status'));
    }
}
