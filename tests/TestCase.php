<?php

namespace Geekhives\BaseRepository\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithFaker, WithoutMiddleware;

    /**
     * Set up
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate')->run();

        $this->withFactories(__DIR__ . '/database/factories');
    }

    /**
     * Define environment setup.
     *
     * @param  Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        //
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['Geekhives\BaseRepository\ServiceProvider'];
    }
}