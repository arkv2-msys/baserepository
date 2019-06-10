<?php

namespace Geekhives\BaseRepository;

use Geekhives\BaseRepository\Service\ExceptionHandler as Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(
            ExceptionHandler::class,
            Handler::class
        );
    }
}