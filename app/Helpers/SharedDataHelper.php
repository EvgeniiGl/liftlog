<?php

namespace App\Helpers;

use Coderello\SharedData\Facades\SharedData;

/**
 * Helper for put data in global window browser for javascript
 * Class SharedDataHelper
 * @package App\Helpers
 */
class SharedDataHelper
{
    /**
     * Помещает данные во view window.laravelSharedData.
     * @param $key string ключ в массиве
     * @param $data array|int|string массив данных для передачи.
     * @return void
     */
    public function put($key, $data)
    {
        SharedData::put([$key => $data]);
    }
}
