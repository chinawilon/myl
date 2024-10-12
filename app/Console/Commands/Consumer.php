<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumer:receive';

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
        $channel->queue_declare('hello', false, false, false, false);
        $channel->queue_bind('hello', 'fanout_ex');
        $channel->basic_qos(null, 1, false);
        $channel->basic_consume('hello', '', false, false, false, false,
            function (AMQPMessage $message) {
                $msg = $message->body;
                sleep(substr_count($msg, '.'));
                echo " [x] Received ", $msg , "\n";
                $message->ack();
            }
        );
        try {
            $channel->consume();
        } catch (\Throwable $e ) {
            echo $e->getMessage();
        } finally {
            $channel->close();
            $connection->close();
        }
    }

}
