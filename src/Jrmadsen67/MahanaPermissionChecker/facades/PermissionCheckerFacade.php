<?php namespace Jrmadsen67\MahanaPermissionChecker\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionCheckerFacade extends Facade
{

    /**
     * Get the registered name of the component
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'mahana_permission_checker';
    }
}