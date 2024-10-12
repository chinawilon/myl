<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'producer:send {msg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbit-rabbitmq', 5672, 'user', 'root');
        $channel = $connection->channel();
        $channel->exchange_declare('fanout_ex', 'fanout');
        $msg = $this->argument('msg');
        $message = new AMQPMessage($msg);
        $channel->basic_publish($message, 'fanout_ex' , 'hello');
        echo '[x] Sent ', $msg, "\n";
    }

}
