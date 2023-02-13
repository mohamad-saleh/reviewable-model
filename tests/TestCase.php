<?php
namespace MohamadSaleh\Reviewable\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MohamadSaleh\Reviewable\ReviewServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }

    protected function getPackageProviders($app)
    {
        return [ReviewServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $config = $app['config'];

        $mysql = $config->get('database.connections.mysql');
        $config->set('database.connections.mariadb', array_merge($mysql, [
            'port' => 3307,
        ]));
    }
}