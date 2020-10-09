<?php

namespace App\Repositories;

use Artisan;
use Config;
use DB;
use Illuminate\Support\Facades\Schema;

class CompanyRepository
{
    public function saveCompany(array $data)
    {
        $company_name = null;
        $company_inn = null;
        $company_phone = null;
        $company_email = null;
        $login = null;
        $password = null;
        extract($data, EXTR_OVERWRITE);
        $sql = "
                WITH ins AS (
                    INSERT INTO companies
                            (name, inn, phone, email, db_name)
                        VALUES
                            (:company_name, :company_inn, :company_phone, :company_email, :db_name)
                        RETURNING id as company_id),
                     ins2 AS (
                         INSERT INTO users
                             (login, password)
                         VALUES
                            (:login, :password)
                         RETURNING id as user_id),
                     ins3 AS (
                         INSERT INTO company_user
                             (company_id, user_id)
                         SELECT company_id, user_id
                             FROM ins, ins2
                         RETURNING company_id, user_id
                     )
                SELECT company_id, user_id
                FROM ins3
        ";
        $params = [
            'company_name' => $company_name,
            'company_inn' => $company_inn,
            'company_phone' => $company_phone,
            'company_email' => $company_email,
            'db_name' => $company_inn,
            'login' => $login,
            'password' => $password,
        ];
        $result = DB::select(DB::raw($sql), $params);
        return $result;
    }

    public function createScheme($data)
    {
        DB::statement(DB::raw("CREATE SCHEMA IF NOT EXISTS inn_{$data['company_inn']}"));
    }
}
