<?php

namespace Kangangga\Emitter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kangangga\Emitter\Skeleton\SkeletonClass
 */
class EmitterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'emitter';
    }
}
