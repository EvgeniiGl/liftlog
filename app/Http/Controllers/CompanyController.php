<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRegisterRequest;
use App\Repositories\CompanyRepository;
use DB;
use Exception;

class CompanyController extends Controller
{
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function registerForm()
    {
        return view('company.register-form');
    }

    public function register(CompanyRegisterRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();

        try {
            $this->companyRepository->saveCompany($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception('Не удалось добавить компанию!'. $e->getMessage());
        }

    }
}
