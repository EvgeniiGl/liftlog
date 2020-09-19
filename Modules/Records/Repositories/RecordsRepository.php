<?php

namespace Modules\Records\Repositories;

use Carbon\Carbon;
use Modules\Records\Models\Record;
use Illuminate\Support\Facades\DB;

class RecordsRepository
{
    // model property on class instances
    protected $model;
    protected $limit = 150;
    protected $columnsRecord = [
        'records.id',
        'num',
        'creator_id',
        'time_create',
        'time_incident',
        'time_evacuation',
        'evacuation',
        'theme',
        'time_sent',
        'maker_id',
        'time_take',
        'time_done',
        'closer_id',
        'theme_end',
        'notice',
        'types.title AS type'
    ];

    public function __construct()
    {
        $this->model = new Record();
    }

    public function getRecords($firstRecord)
    {
        if (!$firstRecord) {
            $lastRecord = $this->model->latest()->first();
            $lastRecordId = empty($lastRecord) ? ++$this->limit : $lastRecord->id;
            $firstRecord = $lastRecordId - $this->limit;
        }
        $sql = "
                SELECT TOP 250 records.id              AS id,
                       records.num,
                       records.creator_id      AS creator_id,
                       records.time_create     AS time_create,
                       records.time_incident   AS time_incident,
                       records.time_evacuation AS time_evacuation,
                       records.evacuation      AS evacuation,
                       records.theme           AS theme,
                       records.time_sent       AS time_sent,
                       records.maker_id        AS maker_id,
                       records.time_take       AS time_take,
                       records.time_done       AS time_done,
                       records.closer_id       AS closer_id,
                       records.theme_end       AS theme_end,
                       records.notice          AS notice,
                       types.title             AS type
                FROM records
                         LEFT JOIN types ON records.type_id = types.id
                GROUP BY records.id, num, creator_id, time_create, time_incident, time_evacuation, evacuation, type_id, theme, time_sent,
                         maker_id, time_take, time_done, closer_id, theme_end, notice, types.title
                ORDER BY records.id DESC
        ";

        $records = array_reverse(DB::select($sql));

        //CONCAT(CONVERT(NVARCHAR(max), address_id, 1)) AS "addresses_id"
        //LEFT JOIN "records_address" ON "records_id" = "records"."id"
        //TODO rewrite it in one request
        //TODO STRING_AGG not working on mssql 2013
        $adrs_id = $this->getAdrsRecords($records)->toArray();
        return $this->setUtcTimeAndAtachAddress($records, $adrs_id);;
    }

    public function getUserRecords($maker_id)
    {
        $tableRecords = 'records';
        $builder = DB::table($tableRecords);
        $builder->where('maker_id', '=', $maker_id);
        $select = $builder->select($this->columnsRecord)->leftJoin('types', 'types.id', '=',
            'records.type_id')->take(100)->orderBy('records.id', 'desc')
            ->get()->toArray();
        $adrs_id = $this->getAdrsRecords($select)->toArray();
        $recordsUser = $this->setUtcTimeAndAtachAddress($select, $adrs_id);
        return $recordsUser;
    }


    public function prependRecords($firstRecord)
    {
        $lastRecord = --$firstRecord - $this->limit;

        $sql = "
                SELECT records.id              AS id,
                       records.num             AS num,
                       records.creator_id      AS creator_id,
                       records.time_create     AS time_create,
                       records.time_incident   AS time_incident,
                       records.time_evacuation AS time_evacuation,
                       records.evacuation      AS evacuation,
                       records.theme           AS theme,
                       records.time_sent       AS time_sent,
                       records.maker_id        AS maker_id,
                       records.time_take       AS time_take,
                       records.time_done       AS time_done,
                       records.closer_id       AS closer_id,
                       records.theme_end       AS theme_end,
                       records.notice          AS notice,
                       types.title             AS type
                FROM records
                LEFT JOIN types ON types.id = records.type_id
                WHERE records.id BETWEEN {$lastRecord} AND {$firstRecord}
                GROUP BY records.id, num, creator_id, time_create, time_incident, time_evacuation, evacuation, theme, time_sent, maker_id, time_take, time_done, closer_id, theme_end, notice, types.title
                ORDER BY records.id ASC
        ";

        $records = DB::select($sql);

        //CONCAT(CONVERT(NVARCHAR(max), address_id, 1)) AS "addresses_id"
        //LEFT JOIN "records_address" ON "records_id" = "records"."id"
        //TODO rewrite it in one request
        $adrs_id = $this->getAdrsRecords($records)->toArray();

        return $this->setUtcTimeAndAtachAddress($records, $adrs_id);
    }


    private function setUtcTimeAndAtachAddress($records, $adrs_id)
    {
        foreach ($records as $record) {
            if (!empty($record->time_create)) {
                $record->time_create = $this->model->getTimeUtc($record->time_create);
            }
            if (!empty($record->time_sent)) {
                $record->time_sent = $this->model->getTimeUtc($record->time_sent);
            }
            if (!empty($record->time_take)) {
                $record->time_take = $this->model->getTimeUtc($record->time_take);
            }
            if (!empty($record->time_evacuation)) {
                $record->time_evacuation = $this->model->getTimeUtc($record->time_evacuation);
            }
            if (!empty($record->time_done)) {
                $record->time_done = $this->model->getTimeUtc($record->time_done);
            }
            if (!empty($record->time_incident)) {
                $record->time_incident = $this->model->getTimeUtc($record->time_incident);
            }
            $this->atachAdrToRecord($record, $adrs_id);
        }
        return $records;
    }

    public function getAdrsRecords($records)
    {
//TODO rewrite it in one request
        $records_id = array_map(function ($record) {
            return gettype($record) === 'array' ? $record['id'] : $record->id;
        }, $records);
        $tableName = "records_address";
        $columns = array(
            DB::raw("CONVERT(NVARCHAR(max), address_id, 1) AS address_id"),
            'records_id'
        );
        $adrs_id = DB::table($tableName)->select($columns)->whereIn('records_id', $records_id)->get();
        return $adrs_id;
    }

    public function atachAdrToRecord($record, $adrs_id)
    {
        $record->addresses_id = [];
        foreach ($adrs_id as $adr) {
            if ($record->id === $adr->records_id) {
                $record->addresses_id[] = $adr->address_id;
            }
        }
    }

    public function create(array $data)
    {
        $data['num'] = $this->model->latest()->first()->num + 1;
        $data['time_create'] = Carbon::now();
//dd($this->model);
        $lastInsertId = $this->model->create($data)->id;
        return $lastInsertId;
    }

    public function atachAddressesToRecord(string $record_id, string $ids_selected_address)
    {
        DB::table('records_address')->where(['records_id' => $record_id])->delete();
        $arrAdrId = explode(",", $ids_selected_address);
        $data = array_map(function ($adrId) use ($record_id) {
            return [
                'records_id' => $record_id,
                'address_id' => DB::raw("CONVERT(VARBINARY(16), $adrId) ")
            ];
        }, $arrAdrId);
        $result = DB::table('records_address')->insert($data);
        return $result;
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        if (!empty($data['time_done']) && empty($data['closer_id'])) {
            $data['closer_id'] = $this->model->closer_id;
        };
//       $result = $record->fill($data)->save();
        return $record->fill($data)->save();
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
//        return $this->model->findOrFail($id);
    }


    public function searchRecordsByIdAddress($id_address)
    {

        $tableRecords = 'records';
        $builder = DB::table($tableRecords);
        $builder->where('address_id', '=', DB::raw("CONVERT(BINARY(16), $id_address, 1)"));
        $builder->leftJoin('records_address', 'id', '=', 'records_id');
        $builder->leftJoin('types', 'records.type_id', '=', 'types.id');
        $select = $builder->select($this->columnsRecord)->take(300)
            ->get()->toArray();
        $adrs_id = $this->getAdrsRecords($select)->toArray();
        $records = $this->setUtcTimeAndAtachAddress($select, $adrs_id);
//        $dataArray = collect($records)->map(function($x){ return (array) $x; })->toArray();
//        dd($dataArray);
        return $records;
        //        die(print_r($select->toArray()));
//              $query   = str_replace(array('?'), array('\'%s\''), $builder->toSql());
//        $query   = vsprintf($query, $builder->getBindings());
//       die(print_r($query));

    }

    public function getUserNewAndInWorkRecords($user_id)
    {
        $records = Record::where([
            [
                'time_sent',
                '!=',
                null
            ],
            [
                'time_done',
                '=',
                null
            ],
            [
                'maker_id',
                '=',
                $user_id
            ],
        ])->select($this->columnsRecord)->get();
        return $records;
    }

    public function getUserCompletedRecords($user_id)
    {
        $items = 7;
        $select = Record::where([
            [
                'time_done',
                '!=',
                null
            ],
            [
                'maker_id',
                '=',
                $user_id
            ],
        ])->select($this->columnsRecord)->orderBy('id', 'desc');
        $records = $select->paginate($items);
        return $records;
    }

    /**
     * Получить отфильтрованные записи
     * @param array $params
     * @return array records
     */
    public function filterRecords(array $params = []): array
    {
        $offset = $params['perPage'] * ($params['page'] - 1);

        $filterByUserId = !empty($params['user_id']) ? " AND (creator_id = {$params['user_id']} OR maker_id = {$params['user_id']} OR closer_id = {$params['user_id']})" : "";

        $filterByAddressId = !empty($params['address_id']) ? " AND address_id = {$params['address_id']}" : "";

        $filterByTimeStart = !empty($params['time_start']) ? " AND time_incident > '{$params['time_start']}'" : "";

        $filterByTimeEnd = !empty($params['time_end']) ? " AND time_incident < '{$params['time_end']}'" : "";

        $filterByType = !empty($params['type_id']) ? " AND type_id = {$params['type_id']}" : "";

        $sql = "
			SELECT
			records.id,
			num,
			creator_id,
			time_create,
			time_incident,
			time_evacuation,
			evacuation,
			theme,
			time_sent,
			maker_id,
			time_take,
			time_done,
			closer_id,
			theme_end,
			notice,
			types.title AS type,
    		(SELECT COUNT(DISTINCT records.id) as count 
    			FROM records 
    				LEFT JOIN records_address ON records_address.records_id = records.id
				    LEFT JOIN types ON records.type_id = types.id
    			WHERE (1=1)
    				{$filterByUserId}
    				{$filterByAddressId}
    				{$filterByTimeStart}
    				{$filterByTimeEnd}
    				{$filterByType}
    		) as total,
			REVERSE(STUFF(REVERSE(STUFF((
                    SELECT '{\"address_id\": \"'
                        + CONVERT(NVARCHAR(max), address_id, 1)
                        + '\", \"address_name\": \"'
                        + _Reference29._Description + ', '
                        + _Reference30._Description + ', '
                        + _Reference10._Fld33
                        + _Reference10._Fld85 + ', '
                        + _Reference10._Fld86
                        + '\"},'
                        AS 'data()'
                    FROM records_address
                             LEFT JOIN _Reference10 ON records_address.address_id = _Reference10._IDRRef
                             LEFT JOIN _Reference29 ON _Reference10._Fld31RRef = _Reference29._IDRRef
                             LEFT JOIN _Reference30 ON _Reference10._Fld32RRef = _Reference30._IDRRef
                    WHERE records.id = records_address.records_id
                    FOR XML PATH('')
                ), 1, 0, '[')), 1, 1, ']')) as addresses
			FROM records
				     LEFT JOIN types ON records.type_id = types.id
				     LEFT JOIN records_address ON records_address.records_id = records.id
			WHERE (1=1)  
				  {$filterByUserId}
				  {$filterByAddressId}
				  {$filterByTimeStart}
				  {$filterByTimeEnd}
				  {$filterByType}
			GROUP BY records.id,
				num,
				creator_id,
				time_create,
				time_incident,
				time_evacuation,
				evacuation,
				theme,
				time_sent,
				maker_id,
				time_take,
				time_done,
				closer_id,
				theme_end,
				notice,
				types.title
			ORDER BY records.id
			OFFSET {$offset} ROWS FETCH NEXT {$params['perPage']} ROWS ONLY;
	    ";
        $records = DB::select($sql);

        return $records;
    }

}
