<?php

namespace App\AdminBundle\Command;

use App\AdminBundle\Socket\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SocketCommand
 * @package App\AdminBundle\Command
 */
class SocketCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('sockets:start-chat')
            ->setHelp('Starting chat on sockets')
            ->setDescription('Starting chat on sockets')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            [
                'Chat socket',
                '============',
                'Starting chat, open your browser.'
            ]
        );

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );

        $server->run();
    }
}