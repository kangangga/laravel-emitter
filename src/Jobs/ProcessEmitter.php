<?php

namespace Kangangga\Emitter\Jobs;

use ElephantIO\Client;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use ElephantIO\Exception\ServerConnectionFailureException;

class ProcessEmitter implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 10;


    /**
     * The url.
     *
     * @var string
     * 
     */
    protected $url;

    /**
     * The ElephantIO instance.
     *
     * @var \ElephantIO\Client
     * 
     */
    protected $client;

    /**
     * The socketIO instance.
     *
     * @var \ElephantIO\Engine\AbstractSocketIO
     * 
     */
    protected $socketIO;

    protected $args;
    protected $event_name;


    /**
     * Create a new job instance.
     * @param  \ElephantIO\Client  $client
     * @return void 
     */
    public function __construct($event_name, $args = [])
    {
        $this->event_name = $event_name;
        $this->args = $args;
        // $this->args = $args;
        // $this->onQueue('sending event...');
        $port = Config::get('emitter.port');
        $host = Config::get('emitter.host');
        $logger = Config::get('emitter.logger');
        $context = Config::get('emitter.socketIO.context');
        $socketIO = Config::get('emitter.socketIO.version');
        $withPort = $port ? ':' . $port : "";


        $this->url = $host . $withPort;
        $this->socketIO = new $socketIO($this->url, array_merge($context, [
            'headers' => [
                'X-My-Header: websocket rocks',
                'Authorization: Bearer kawdawdasndkasndksandsnadks'
            ],
            'query' => [
                'token' => 'abc'
            ]
        ]));
        $this->client = new Client($this->socketIO, new $logger);
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return \Str::uuid();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->client->initialize();
            $this->client->emit($this->event_name, $this->args);
            $this->client->close();
        } catch (ServerConnectionFailureException $exception) {
            $this->fail($exception);
        }
    }
}
