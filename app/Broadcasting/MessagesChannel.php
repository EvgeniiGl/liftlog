<?php

namespace App\Broadcasting;

use App\User;

class MessagesChannel
{
    /**
     * @param User $user
     * @param int $task_id
     * @return bool
     */
    public function join(User $user, int $task_id)
    {
        return true || false;
    }
}
