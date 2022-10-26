<?php

namespace App\Services;

use App\Services\CustomResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class HttpResponse
{

    private CustomResponse $customResponse;    

    public function __construct(CustomResponse $customResponse)
    {
        $this->customResponse = $customResponse;
    }

    public function setHttpResponse(Collection|LengthAwarePaginator $items):object
    {
        if((count($items) < 1)){
            return $this->customResponse->httpResponse('error', $items);
        }

        return $this->customResponse->httpResponse('ok', $items);
    }

    public function setExceptionAndLogNotCreatedInstance($e): object
    {
        return $this->customResponse->httpResponse('error');
    }

    public function setHttpResponseCreatedOneInstance(Model $model): object 
    {
        if(empty($model)){
            return $this->customResponse->httpResponse('request');
        }

        return $this->customResponse->httpResponse('created', $model);
    }

    public function setHttpResponseItemDeleted(): object
    {
        return $this->customResponse->httpResponse('deleted');
    }
}