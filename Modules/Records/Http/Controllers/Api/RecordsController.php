<?php

namespace Modules\Records\Http\Controllers\Api;

use App\Events\RecordsChanged;
use App\Helpers\View\AddressHelper;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Http\Requests\RecordsDoneRequest;
use Modules\Records\Http\Requests\RecordsTakeRequest;
use Modules\Records\Models\Record;
use Modules\Records\Repositories\RecordsRepository;
use ResponseHelper;

class RecordsController extends Controller
{

    protected $addressRepository;
    protected $recordsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addressRepository = new AddressRepository();
        $this->recordsRepository = new RecordsRepository();
    }

    /**
     * Get new records.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAppointedRecords()
    {
        $user       = Auth::user();
        $newRecords = $this->recordsRepository->getUserNewAndInWorkRecords($user->id);
        $addresses  = $this->addressRepository->getAddressByRecords($newRecords);
        $newRecords = AddressHelper::getRecordsWithAddresses($newRecords, $addresses);
        $data       = ['records' => $newRecords];
        return response()->json($data);
    }

    /**
     * Get completed records.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCompletedRecords(Request $request)
    {

        $page = $request->page;
        $user             = Auth::user();
        $completedRecords = $this->recordsRepository->getUserCompletedRecords($user->id, $page);

        $addresses = $this->addressRepository->getAddressByRecords($completedRecords->items());
        $completedRecords->getCollection()->transform(function ($value) use ($addresses) {
            return AddressHelper::getRecordsWithAddresses([$value], $addresses)[0];
        });
        $data['records'] = $completedRecords;
        return response()->json($data);
    }

    public function take(RecordsTakeRequest $request)
    {
        $user = Auth::user();
//        if ($user->cannot('write', $record)) {
//            $data = ['message' => 'Нет прав на редактирование!'];
//            return response()->json($data);
//        }
        $data = $request->validated();
        $time = Carbon::now();
        Record::where("id", $data['id'])->update(["time_take" => $time]);
        event(new RecordsChanged($data['id']));
        return response()->json(["time_take" => $time]);
    }

    public function done(RecordsDoneRequest $request)
    {
        $user = Auth::user();
//        if ($user->cannot('write', $record)) {
//            $data = ['message' => 'Нет прав на редактирование!'];
//            return response()->json($data);
//        }
        $data   = $request->validated();
        $record = Record::find($data['id']);
        $record->update($data);
        event(new RecordsChanged($record->id));
        return ResponseHelper::successResponse();
    }
}
