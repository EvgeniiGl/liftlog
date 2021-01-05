<?php

namespace Modules\Records\Http\Controllers;

use App\Events\RecordsChanged;
use App\Helpers\SharedDataHelper;
use App\Helpers\View\AddressHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendFirebaseMessageJob;
use App\Models\Type;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Http\Requests\RecordsDoneRequest;
use Modules\Records\Http\Requests\RecordsRequest;
use Modules\Records\Http\Requests\RecordsSentRequest;
use Modules\Records\Http\Requests\RecordsSetTimeEvacuationRequest;
use Modules\Records\Http\Requests\RecordsTakeRequest;
use Modules\Records\Models\Record;
use Modules\Records\Repositories\RecordsRepository;
use Modules\Users\Repositories\UsersRepository;
use Session;


class RecordsController extends Controller
{
    /**
     * @var RecordsRepository
     */
    protected $recordsRepository;

    /**
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * @var AddressRepository
     */
    protected $addressRepository;
    private $sharedDataHelper;

    /**
     * RecordsController constructor.
     * @param RecordsRepository $recordsRepository
     * @param AddressRepository $addressRepository
     * @param UsersRepository $usersRepository
     * @param SharedDataHelper $sharedDataHelper
     */
    public function __construct(
        RecordsRepository $recordsRepository,
        AddressRepository $addressRepository,
        UsersRepository $usersRepository,
        SharedDataHelper $sharedDataHelper
    ) {
        $this->recordsRepository = $recordsRepository;
        $this->usersRepository   = $usersRepository;
        $this->addressRepository = $addressRepository;
        $this->sharedDataHelper  = $sharedDataHelper;
    }


    /**
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
//        $user       = Auth::user();
//        $newRecords = $this->recordsRepository->getUserNewAndInWorkRecords($user->id);
//        $addresses  = $this->addressRepository->getAddressByRecords($newRecords);
//        $newRecords = AddressHelper::getRecordsWithAddresses($newRecords, $addresses);
//        dd($newRecords);
        $record = new Record();
        $user   = Auth::user();
        if ($user !== null && $user->cannot('view', $record)) {
            Session::flash('message', 'Доступ запрещен!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('login');
        }

        $currentUser = [
            'id'   => Auth::id(),
            'name' => $user->name,
            'role' => $user->role
        ];

        $types = Type::all();

        $this->sharedDataHelper->put("currentUser", $currentUser);
        $this->sharedDataHelper->put("types", $types);
        return view('records::index');
    }

    /**
     * Api init get list records, users, attach addresses
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getRecords(Request $request): JsonResponse
    {
        $record = new Record();
        $user   = Auth::user();
        if ($user->cannot('view', $record)) {
            $data = ['message' => 'Доступ запрещен!'];
            return response()->json($data);
        }
        $firstRecord     = $request->firstRecord;
        $data            = [];
        $records         = $this->recordsRepository->getRecords($firstRecord);
        $data['records'] = $records;
        $users           = $this->usersRepository->all();
        $data['users']   = $users;
        $addresses       = $this->addressRepository->getAddressByRecords($data['records']);
        $data['records'] = AddressHelper::getRecordsWithAddresses($records, $addresses);
        return response()->json($data);
    }

    public function prependRecords(Request $request)
    {
        $record = new Record();
        $user   = Auth::user();
        if ($user->cannot('view', $record)) {
            $data = ['message' => 'Доступ запрещен!'];
            return response()->json($data);
        }
        $firstRecord     = $request->firstRecord;
        $data            = [];
        $records         = $this->recordsRepository->prependRecords($firstRecord);
        $data['records'] = $records;
        $addresses       = $this->addressRepository->getAddressByRecords($data['records']);
        $data['records'] = AddressHelper::getRecordsWithAddresses($records, $addresses);
        return response()->json($data);
    }


    /**
     * Store a newly create record, and notify users
     *
     * @param RecordsRequest $request
     * @return JsonResponse
     */
    public function store(RecordsRequest $request)
    {
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data               = $request->validated();
        $data['creator_id'] = $user->id;
        $type   = new Type();
        $data['type_id']    = $type->firstOrNew(['title' => $data['type']])->id;
        unset($data['type']);
        $lastInsertId = $this->recordsRepository->create($data);
        $this->recordsRepository->attachAddressesToRecord($lastInsertId, $data['ids_selected_adr']);
        event(new RecordsChanged($lastInsertId));
        if (!empty($data['maker_id'])) {
            $msg = \App::make("App\Services\Firebase\SentRecordMessage");
            $msg->setData($data);
            SendFirebaseMessageJob::dispatch($msg);
        }
        return response()->json([
            "message" => "Запись добавлена",
            "errors"  => null,
            'status'  => true
        ]);
    }

    public function update(RecordsRequest $request)
    {
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data = $request->validated();
        $type   = new Type();
        $data['type_id']    = $type->firstOrNew(['title' => $data['type']])->id;
        unset($data['type']);
        $this->recordsRepository->update($data, $data['id']);
        $this->recordsRepository->attachAddressesToRecord($data['id'], $data['ids_selected_adr']);

        event(new RecordsChanged($data['id']));
        return response()->json([
            "message" => "Запись изменена",
            "errors"  => null,
            'status'  => true
        ]);
    }

    /**
     *
     * @param RecordsRequest $request
     * @return JsonResponse
     */
    public function sent(RecordsSentRequest $request)
    {
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data              = $request->validated();
        $data['time_sent'] = Carbon::now();
        $this->recordsRepository->update($data, $data['id']);
        $msg = \App::make("App\Services\Firebase\SentRecordMessage", ['data' => $data]);
        SendFirebaseMessageJob::dispatch($msg);
        event(new RecordsChanged($data['id']));
        return response()->json([
            "message" => "Отправлено",
            "errors"  => null,
            'status'  => true
        ]);
    }

    /**
     *
     * @param RecordsRequest $request
     * @return JsonResponse
     */
    public function take(RecordsTakeRequest $request)
    {
        //TODO rewrite use eloquent model
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data              = $request->validated();
        $data['time_take'] = Carbon::now();
        $this->recordsRepository->update($data, $data['id']);

        event(new RecordsChanged($data['id']));
        return response()->json([
            "message" => "Отправлено",
            "errors"  => null,
            'status'  => true
        ]);
    }

    public function setTimeEvacuation(RecordsSetTimeEvacuationRequest $request)
    {
        //TODO rewrite use eloquent model
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data = $request->validated();
        $this->recordsRepository->update($data, $data['id']);
        event(new RecordsChanged($data['id']));
        return response()->json([
            "message" => "Отправлено",
            "errors"  => null,
            'status'  => true
        ]);
    }

    public function done(RecordsDoneRequest $request)
    {
        //TODO rewrite use eloquent model
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $data              = $request->validated();
        $data['closer_id'] = $user->id;
        $this->recordsRepository->update($data, $data['id']);
        event(new RecordsChanged($data['id']));
        return response()->json([
            "message" => "Отправлено",
            "errors"  => null,
            'status'  => true
        ]);
    }

    public function searchRecordsByIdAddress(Request $request)
    {
        //TODO rewrite use eloquent model
        $record = new Record();
        $user   = Auth::user();
        if ($user->cannot('view', $record)) {
            $data = ['message' => 'Доступ запрещен!'];
            return response()->json($data);
        }
        $id_address      = $request->id_address;
        $data            = [];
        $records         = $this->recordsRepository->searchRecordsByIdAddress($id_address);
        $data['records'] = $records;
        $addresses       = $this->addressRepository->getAddressByRecords($data['records']);
        $data['records'] = AddressHelper::getRecordsWithAddresses($records, $addresses);
        return response()->json($data);
    }

    public function remove(Request $request)
    {
        //TODO rewrite use eloquent model
        $user   = Auth::user();
        $record = new Record();
        if ($user->cannot('write', $record)) {
            $data = ['message' => 'Нет прав на редактирование!'];
            return response()->json($data);
        }
        $id = $request->id;
        $this->recordsRepository->delete($id);
        event(new RecordsChanged($id));
        return response()->json([
            "message" => "Запись удалена",
            "errors"  => null,
            'status'  => true
        ]);
    }

}
