<?php

namespace App\Services\Socket;


class ConnectionPool
{
    /**
     * @var Connection[]
     */
    private $connections = array();

    /**
     * Добавляет соединение в пул
     *
     * @param Connection $connection
     * @return void
     */
    public function pushConnection(Connection $connection)
    {
        $id = $connection->getConnectionId();
        if (isset($this->connections[$id])) {
            unset($this->connections[$id]);
        }
        $this->connections[$id] = $connection;
    }

    /**
     * Возвращает соединение из пула
     *
     * @param string $id - идентификатор пользователя
     * @return Connection | void $connection
     */
    public function getConnectionByUserId(string $id)
    {
        foreach ($this->connections as $connection) {
            if ($connection->getUserId() === (int)$id) {
                return $connection;
            }
        }
    }

    /**
     * Удаляет соединение из пула
     *
     * @param string $connectionId - идентификатор соединения
     * @return void
     */
    public function removeConnection(string $id)
    {
        foreach ($this->connections as $connection) {
            if ($connection->getConnectionId() === $id) {
                unset($this->connections[$connection->getConnectionId()]);
            }
        }
    }

    /**
     * Get all connections
     *
     * @return Connection[]
     */
    public function all()
    {
        return $this->connections;
    }

}


