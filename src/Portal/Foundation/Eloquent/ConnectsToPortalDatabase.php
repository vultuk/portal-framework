<?php namespace Portal\Foundation\Eloquent;

trait ConnectsToPortalDatabase {

    protected static function bootConnectsToPortalDatabase()
    {
        dd(static::$connection);
    }

}