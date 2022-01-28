<?php

namespace Kangangga\Emitter\Logs;

use Psr\Log\LogLevel;
use Psr\Log\AbstractLogger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class EmitterLogger extends AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        if (Config::get('emitter.socketIO.context.debug')) {
            Log::{$level}($message, $context);
        }
    }
}
