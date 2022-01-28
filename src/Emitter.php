<?php

namespace Kangangga\Emitter;

use ElephantIO\Client;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use ElephantIO\Engine\SocketIO\Version4X;
use Kangangga\Emitter\Jobs\ProcessEmitter;
use ElephantIO\Exception\ServerConnectionFailureException;

class Emitter
{
    /**
     * emit function
     *
     * @param string $event_name
     * @param array $args
     * @return \Illuminate\Support\Facades\Bus
     */
    public static function emit($event_name, $args = [])
    {
        return Bus::batch([
            new ProcessEmitter($event_name, $args)
        ])->then(function (Batch $batch) {
            return $batch;
        })->catch(function (Batch $batch, \Throwable $e) {
            return $batch;
        })->name("Emitter : $event_name")->dispatch();
    }
}
