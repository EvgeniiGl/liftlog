<?php

namespace Modules\Personal\Http\Controllers;

use App\Helpers\SharedDataHelper;
use App\Helpers\View\AddressHelper;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Models\Record;
use Modules\Records\Repositories\RecordsRepository;
use Session;

class PersonalController extends Controller
{
    protected $recordsRepository;
    protected $addressRepository;
    private $sharedDataHelper;

    public function __construct()
    {
        $this->recordsRepository = new RecordsRepository();
        $this->addressRepository = new AddressRepository();
        $this->sharedDataHelper  = new SharedDataHelper();
    }

    public function index()
    {
        $record = new Record();
        $user   = Auth::user();
        if ($user->cannot('view', $record)) {
            Session::flash('message', 'Доступ запрещен!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('login');
        }
        $this->sharedDataHelper->put("currentUser", [
            'id'   => Auth::id(),
            'name' => Auth::user()->name,
            'role' => Auth::user()->role
        ]);
        return view('personal::index');
    }

    public function getUserRecords(Request $request)
    {
        $record = new Record();
        $user   = Auth::user();
        if ($user->cannot('view', $record)) {
            $data = ['message' => 'Доступ запрещен!'];
            return response()->json($data);
        }
        $data              = [];
        $records           = $this->recordsRepository->getUserRecords($user->id);
        $data['records']   = $records;
        $addresses         = $this->addressRepository->getAddressByRecords($data['records']);
        $data['records']   = AddressHelper::getRecordsWithAddresses($records, $addresses);
        return response()->json($data);
    }

}
