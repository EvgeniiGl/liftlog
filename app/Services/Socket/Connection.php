<?php

namespace App\Services\Socket;


class Connection
{
    /**
     * @var string id connection
     */
    protected $connectionId;
    /**
     * @var int id user
     */
    protected $userId;
    /**
     * @var int count ping without response
     */
    protected $pingWithoutResponseCount;
    /**
     * @var resource socket connection
     */
    protected $connect;
    /**
     * @var string status notificate
     */
    protected $notificate;

    /**
     * Connection constructor.
     * @param string $connectionId
     */
    public function __construct(string $connectionId)
    {
        $this->connectionId = $connectionId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getConnectionId()
    {
        return $this->connectionId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setPingWithoutResponseCount($count)
    {
        $this->pingWithoutResponseCount = $count;
    }

    public function getConnect()
    {
        return $this->connect;
    }

    public function setConnect($connect)
    {
        $this->connect = $connect;
    }

    public function getNotificate()
    {
        return $this->notificate;
    }

    public function setNotificate($notificate)
    {
        $this->notificate = $notificate;
    }
}

