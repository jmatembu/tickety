<?php

<<<<<<< HEAD
=======
use App\Exceptions\Handler;

>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $baseUrl = 'https://tickety.app';
=======
    protected $baseUrl = 'http://localhost';

>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
<<<<<<< HEAD
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }
=======

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(Exception $e) {}
            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }
>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
}
