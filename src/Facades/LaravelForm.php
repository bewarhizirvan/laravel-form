<?php

namespace BewarHizirvan\LaravelForm\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelForm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelform';
    }
}
