<?php

namespace Modules\Address\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Address\Http\Requests\AddressRequest;
use Modules\Address\Repositories\AddressRepository;

class AddressController extends Controller
{

    /**
     * @var AddressRepository
     */
    protected $addressRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addressRepository = new AddressRepository();
    }

    public function loadAddress(AddressRequest $request) {

        $str = $request->validated();
        $data = $this->addressRepository->getAddressByStrSearch($str);

        return response()->json($data);
    }
}
