<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionContoller extends BaseController
{

    protected $resource = TransactionResource::class;

    /**
     * The OrderService service instance.
     *
     * @var TransactionService
     */
    protected $service;

    public function __construct(TransactionService $service)
    {
        parent::__construct($service);
    }
}
