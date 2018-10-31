<?php

namespace Woddp\Notemenu\Facades;


use Illuminate\Support\Facades\Facade;

class Notemenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notemenu';
    }

}