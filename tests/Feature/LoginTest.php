<?php

namespace Tests\Feature;

use App\Http\Middleware\DummyMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // swap out the middleware you wish not to use with a dummy middleware that always passes
        $this->app->instance(\App\Http\Middleware\VerifyCsrfToken::class, new DummyMiddleware());
        $this->app->instance(\App\Http\Middleware\Cors::class, new DummyMiddleware());
    }

    public function testLoginPageAvailable()
    {
        $response = $this->call('GET', '/');
        $response->assertStatus(200);
    }

    public function testRedirectsLoginPageIfNotAuthorized()
    {
        $response = $this->call('GET', '/users');
        $response->assertStatus(302);
    }

}
