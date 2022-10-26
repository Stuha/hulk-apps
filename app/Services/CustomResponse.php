<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CustomResponse
{
    private array $ok = ['http_status' => ResponseAlias::HTTP_OK, 'response' => ['success' => 'true']];
    private array $created = ['http_status' => ResponseAlias::HTTP_CREATED, 'response' => ['created' => 'true']];
    private array $error = ['http_status' => ResponseAlias::HTTP_BAD_REQUEST, 'response' => 'Something went wrong'];
    private array $deleted = ['http_status' => ResponseAlias::HTTP_OK, 'response' => ['deleted' => 'true']];


    public function httpResponse($status, $response = null): object 
    {
        $this->$status['response'] = $response ?? $this->$status['response'];
        return  (object) $this->$status;
    }
}