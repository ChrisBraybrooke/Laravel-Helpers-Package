<?php

namespace ChrisBraybrooke\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionChecker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permission-checker';
    }
}