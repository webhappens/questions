<?php

namespace WebHappens\Questions\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use WebHappens\Questions\QuestionsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->artisan('migrate')->run();
    }

    protected function getPackageProviders($app)
    {
        return [QuestionsServiceProvider::class];
    }
}
