<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    //
    protected $resource = UserResource::class;

        /**
     * The OrderService service instance.
     *
     * @var UserService
     */
    protected $service;

    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

}
