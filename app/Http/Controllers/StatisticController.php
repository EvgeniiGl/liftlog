<?php

namespace App\Http\Controllers;

use App\Helpers\SharedDataHelper;
use App\Helpers\View\DateTimeHelper;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Address\Repositories\AddressRepository;
use Modules\Records\Repositories\RecordsRepository;
use Modules\Users\Repositories\UsersRepository;
use ResponseHelper;

class StatisticController extends Controller
{

    /**
     * @var RecordsRepository
     */
    private $recordsRepository;
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var SharedDataHelper
     */
    private $sharedDataHelper;

    /**
     * StatisticController constructor.
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
        $this->usersRepository = $usersRepository;
        $this->addressRepository = $addressRepository;
        $this->sharedDataHelper = $sharedDataHelper;
    }

    public function index(Request $request)
    {
        $types = Type::all();
        $users = $this->usersRepository->all();
        $recordsPaginate = $this->getFilteredPaginatedRecords($request);
        $this->sharedDataHelper->put("types", $types);
        $this->sharedDataHelper->put("users", $users);
        $this->sharedDataHelper->put("records", $recordsPaginate);
        return view('statistic.index');
    }

    /**
     * @SWG\Get(
     *     path="/statistic/filter",
     *     summary="Filter records",
     *     tags={"Statistic"},
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page number",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="app/Http/Controllers/statistic_filter.json"),
     *  ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     * )
     */
    public function filter(Request $request)
    {
        if (!$request->wantsJson()) {
            return redirect()->route('statistic', $request->all());
        }
        $recordsPaginate = $this->getFilteredPaginatedRecords($request);
        ResponseHelper::setData($recordsPaginate);
        return ResponseHelper::successResponse();
    }

    private function getFilteredPaginatedRecords(Request $request)
    {
        $params = $request->all();
        $configPaginate = config('paginate.statistic');
        $params['time_start'] = DateTimeHelper::reformatStringToTime($params['time_start'] ?? null);
        $params['time_end'] = DateTimeHelper::reformatStringToTime($params['time_end'] ?? null);
        $records = $this->recordsRepository->filterRecords(array_merge($configPaginate, $params));
        return $records ? new LengthAwarePaginator($records, $records[0]->total, $configPaginate['perPage'],
            $params['page'] ?? $configPaginate['page']) : null;
    }

}
