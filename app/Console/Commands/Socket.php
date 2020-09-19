<?php

namespace App\Console\Commands;

use App\Events\NotificationChangeRecords;
use App\Services\Socket\Connection;
use App\Services\Socket\ConnectionPool;
use App\User;
use Illuminate\Console\Command;
use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;
use Workerman\Worker;

class Socket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:serve {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'управляет вебсокет сервером workerman';

    /**
     * Run socket.
     */
    public function handle()
    {
        global $argv;
        $arg      = $this->argument('action');
        $argv [1] = $arg;

        $pConnect = new ConnectionPool();
        $io       = new SocketIO(8086);

//создаем демона для проверки и отправки изменений
        $io->on('workerStart', function () use (&$pConnect) {
            $time_interval = 10;
            Timer::add($time_interval, function () use (&$socket, &$pConnect) {
                foreach ($pConnect->all() as $connection) {
                    echo "connected: \r\n";
                    echo "{$connection->getUserId()}, ";
                }
                echo "\n";
                $recordsId = \Cache::get('records_chahged');
                echo 'r-' . $recordsId;
                if (!empty($recordsId)) {
//                    foreach ($pConnect->all() as $connection) {
//                       $connection->getConnect()->emit("some", 'data');
//                    }
                    event(new NotificationChangeRecords($recordsId, $pConnect));
                }
            });
        });

//записываем соединения пользователей
        $io->on('connection',
            function ($socket) use (&$pConnect) {
                echo "start new connection\n";
                $socket->emit('connected');
// Получаем токен и пользователя
                $socket->on('send token', function ($token) use (&$socket, &$pConnect) {
                    if (empty($token)) {
                        $socket->send('Не авторизован!');
                    }
                    $user = User::getUserByToken($token);
// Добавляем соединение в список
                    if (!empty($user)) {
                        $connection = new Connection($socket->id);
                        $connection->setUserId($user->id);
                        $connection->setNotificate($user->notificate);
                        $connection->setPingWithoutResponseCount(0);
                        $connection->setConnect($socket);
                        $pConnect->pushConnection($connection);
                    } else {
                        $socket->send('Не удалось получить пользователя!');
                        return;
                    }
                });
// Удаляем соединение из списка при отключении
                $socket->on('disconnect', function ($connectionId) use (&$pConnect) {
                    $pConnect->removeConnection($connectionId);
                });
            });
// Run worker
        Worker::runAll();
    }
}
