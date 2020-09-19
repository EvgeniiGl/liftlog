<?php

namespace Modules\Address\Repositories;

use App\Helpers\View\AddressHelper;
use Illuminate\Support\Facades\DB;
use Modules\Address\Models\Address;

class AddressRepository
{
	protected $model;
	protected $tableName;
	protected $columnsName;
	protected $columns;
	protected $config = [
		"table" => "_Reference10",
		"columns" => array(
			"id" => "_IDRRef",
			"description" => "_Description",
			"factory_num" => "_Fld13",
			"reg_num" => "_Fld14",
			"date_commissioning" => "_Fld15",
			"period_end" => "_Fld216",
			"inn_customer" => "_Fld184",
			"house" => "_Fld33",
			"house_letter" => "_Fld85",
			//            "entrance" => "_Fld86",
			"num_lift" => "_Fld86",
			"model" => "_Fld66",
			"speed" => "_Fld77",
			"height" => "_Fld79",
			"weight" => "_Fld80",
			"floor" => "_Fld84",
			"year_manufacture" => "_Fld67",
			"year_replacement" => "_Fld207",
			"appointment" => array(
				"ref" => "_Fld87RRef",
				'table' => "_Reference133",
				"id" => "_IDRRef",
				"column" => "_Description"
			),
			"city" => array(
				"ref" => "_Fld31RRef",
				'table' => "_Reference29",
				"id" => "_IDRRef",
				"column" => "_Description"
			),
			"street" => array(
				"ref" => "_Fld32RRef",
				'table' => "_Reference30",
				"id" => "_IDRRef",
				"column" => "_Description"
			),
		)
	];

	public function __construct()
	{
		$this->model = new Address();
		$this->tableName = $this->config['table'];
		$this->columnsName = $this->config['columns'];
		$this->columns = array(
			DB::raw("CONVERT(NVARCHAR(max), " . $this->tableName . "." . $this->columnsName['id'] . ", 1) AS id"),
			$this->tableName . "." . $this->columnsName['house'] . ' AS house',
			$this->tableName . "." . $this->columnsName['house_letter'] . ' AS house_letter',
			//            "entrance"=>$this->columns['entrance'] ,
			$this->tableName . "." . $this->columnsName['num_lift'] . ' AS num_lift',
			//            $this->tableName . "." . $this->columnsName['reg_num'] . ' AS reg_num',
			$this->columnsName['city']['table'] . "." . "_Description AS city",
			$this->columnsName['street']['table'] . "." . "_Description AS street"
		);
	}

	public function getAddressByRecords(iterable $records)
	{
		//TODO rewrite change $records to records id
		$records = gettype($records) === 'array' ? $records : $records->toArray();
		$recordsId = array_map(function ($record) {
			return gettype($record) === 'array' ? $record['id'] : $record->id;
		}, $records);
		$builder = DB::table($this->tableName);
		$builder->leftJoin($this->columnsName['city']['table'],
			$this->columnsName['city']['table'] . "." . $this->columnsName['city']['id'], '=',
			$this->tableName . '.' . $this->columnsName['city']['ref']);
		$builder->leftJoin($this->columnsName['street']['table'],
			$this->columnsName['street']['table'] . "." . $this->columnsName['street']['id'], '=',
			$this->tableName . '.' . $this->columnsName['street']['ref']);
		$builder->leftJoin("records_address", "address_id", "=", "_Reference10._IDRRef")->whereIn("records_id",
			$recordsId);
		$this->columns[] = 'records_id';
		$addresses = $builder->select($this->columns)->get()->toArray();
		return $addresses;
	}

	public function getAddressByStrSearch($search)
	{
		$data = [];
		$patterns = [
			'/,/',
			'/лифт/i',
			'/город/i',
			'/дом/i',
			'/г[ ]/i',
			'/д[ ]/i',
			'/л[ ]/i',
			'/г[.]/i',
			'/д[.]/i',
			'/л[.]/i',
			'/№/i',
			'/\(/i',
			'/\)/i',
			'/\./i',
		];
		$search = preg_replace("/ +/", ' ', preg_replace($patterns, ' ', $search['str_search']), -1);
		$partsSearch = explode(" ", $search);
		$columns = array(
			DB::raw("MIN(CONVERT(NVARCHAR(max), " . $this->tableName . "." . $this->columnsName['id'] . ", 1)) AS id"),
			$this->tableName . "." . $this->columnsName['house'] . ' AS house',
			$this->tableName . "." . $this->columnsName['house_letter'] . ' AS house_letter',
			$this->tableName . "." . $this->columnsName['num_lift'] . ' AS num_lift',
			$this->columnsName['city']['table'] . "." . "_Description AS city",
			$this->columnsName['street']['table'] . "." . "_Description AS street"
		);
		$builder = DB::table($this->tableName);
		$builder->leftJoin($this->columnsName['city']['table'],
			$this->columnsName['city']['table'] . "." . $this->columnsName['city']['id'], '=',
			$this->tableName . '.' . $this->columnsName['city']['ref']);
		$builder->leftJoin($this->columnsName['street']['table'],
			$this->columnsName['street']['table'] . "." . $this->columnsName['street']['id'], '=',
			$this->tableName . '.' . $this->columnsName['street']['ref']);

		$builder1 = clone $builder;
		foreach ($partsSearch as $part) {
			$builder->where(function ($q) use ($part) {
				$q->where($this->columnsName['city']['table'] . "." . "_Description", '=', $part)
					->orWhere($this->columnsName['street']['table'] . "." . "_Description", '=', $part)
					->orWhere($this->columnsName['house'], '=', $part)
					->orWhere($this->columnsName['house_letter'], '=', $part)
					->orWhere($this->columnsName['num_lift'], '=', $part);
//                    ->orWhere($this->columnsName['reg_num'], 'like', $part);
			});
		}
		$builder->groupBy(['_Reference10._Fld33',
				'_Reference10._Fld85',
				'_Reference10._Fld86',
				'_Reference29._Description',
				'_Reference30._Description']
		);
		$select = $builder->select($columns)->take(5)->get();
		//      print_r($select->toArray());
//                $query   = str_replace(array('?'), array('\'%s\''), $builder->toSql());
//        $query   = vsprintf($query, $builder->getBindings());
		foreach ($select->toArray() as $adr) {
			$data[] = AddressHelper::getPreparedAddress($adr);
		}

		foreach ($partsSearch as $part) {
			$builder1->where(function ($q) use ($part) {
				$q->where($this->columnsName['city']['table'] . "." . "_Description", 'like', '%' . $part . '%')
					->orWhere($this->columnsName['street']['table'] . "." . "_Description", 'like', '%' . $part . '%')
					->orWhere($this->columnsName['house'], 'like', '%' . $part . '%')
					->orWhere($this->columnsName['house_letter'], 'like', '%' . $part . '%')
					->orWhere($this->columnsName['num_lift'], 'like', '%' . $part . '%');
//                    ->orWhere($this->columnsName['reg_num'], 'like', '%' . $search . '%');
			});
		}

		$builder1->groupBy(['_Reference10._Fld33',
				'_Reference10._Fld85',
				'_Reference10._Fld86',
				'_Reference29._Description',
				'_Reference30._Description']
		);
		//remove dublicate
		if(!empty($data)) {
            $builder1->havingRaw(DB::raw("MIN(CONVERT(NVARCHAR(max), _Reference10._IDRRef, 1)) not in (" . implode(',',
                    array_map(function ($item) {
                        return "'{$item}'";
                    }, array_column($data, 'address_id'))) . ")"));
        }

		$select1 = $builder1->select($columns)->take(25)->get();
//                $query   = str_replace(array('?'), array('\'%s\''), $builder1->toSql());
//        $query   = vsprintf($query, $builder1->getBindings());
//die(
//	"<pre>".print_r($query, true)."</pre>".
//	"<pre>".print_r(__FILE__.' '.__LINE__, true)."</pre>");
		foreach ($select1->toArray() as $adr) {
			$data[] = AddressHelper::getPreparedAddress($adr);
		}
		return $data;
	}

	/**
	 * @param array $ids
	 * @return array|iterable
	 */
	public function getAddressByIds(array $ids)
	{
		$ids = array_map(function ($id) {
			return DB::raw("CONVERT(VARBINARY(16), $id)");
		}, $ids);
		$builder = DB::table($this->tableName);
		$builder->leftJoin($this->columnsName['city']['table'],
			$this->columnsName['city']['table'] . "." . $this->columnsName['city']['id'], '=',
			$this->tableName . '.' . $this->columnsName['city']['ref']);
		$builder->leftJoin($this->columnsName['street']['table'],
			$this->columnsName['street']['table'] . "." . $this->columnsName['street']['id'], '=',
			$this->tableName . '.' . $this->columnsName['street']['ref']);
		$builder->whereIn($this->tableName . '.' . $this->columnsName['id'], $ids);
		$addresses = $builder->select($this->columns)->get()->toArray();
		return $addresses;
	}

}
