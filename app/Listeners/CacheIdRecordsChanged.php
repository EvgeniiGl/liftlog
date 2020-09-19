<?php

namespace App\Listeners;

use App\Events\RecordsChanged;
use Illuminate\Support\Facades\Cache;

class CacheIdRecordsChanged
{
    /**
     * Save id changed record to cache for use into socket
     *
     * @param RecordsChanged $event
     * @return void
     */
    public function handle(RecordsChanged $event)
    {
        $listId = json_decode(Cache::get('records_chahged'));
        $listId[] = $event->recordId;
        Cache::put('records_chahged', json_encode($listId), 12);
    }
}
