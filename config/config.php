<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'host' => 'http://localhost',
    'port' => 1235,
    'logger' => \Kangangga\Emitter\Logs\EmitterLogger::class,
    'socketIO' => [
        'context' => [
            "debug" => false,
            "wait" => 50,
            "timeout" => "60",
            "version" => 4,
            "use_b64" => false,
            "transport" => "polling",
            "max_payload" => 1000000.0,
        ],
        'version' => \ElephantIO\Engine\SocketIO\Version4X::class,
    ]
];
