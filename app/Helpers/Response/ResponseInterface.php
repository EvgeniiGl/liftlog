<?php

namespace App\Helpers\Response;

interface ResponseInterface
{
    static public function getStatus();

    static public function getMessage();

    static public function getData();

    static public function getCode();

    static public function setStatus(bool $status);

    static public function setMessage(string $message);

    static public function setData(array $data);

    static public function setCode(int $code);

    static public function successResponse();

    static public function errorResponse();
}
