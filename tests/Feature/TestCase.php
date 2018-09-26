<?php

namespace WebHappens\Questions\Tests\Feature;

use Orchestra\Testbench\TestCase as Orchestra;
use WebHappens\Questions\QuestionsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->artisan('migrate')->run();
        $this->withFactories(__DIR__ . '/../../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [QuestionsServiceProvider::class];
    }
}
