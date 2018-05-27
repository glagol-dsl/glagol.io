<?php
declare(strict_types=1);
namespace Test;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;
use Laravel\Passport\Client;

abstract class TestCase extends LumenTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('passport:install');
        $client = Client::query()->where('password_client', 1)->first();
        config([
            'auth.defaults.client_credentials.client_id' => $client->id,
            'auth.defaults.client_credentials.client_secret' => $client->secret,
        ]);
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
