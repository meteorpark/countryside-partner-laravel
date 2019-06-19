<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @param Request $request
     * @param UserService $userService
     * @return mixed
     */
    protected function userInfo(Request $request, UserService $userService)
    {
        $data = $request->all();

        return $userService->getUser($data['user_type'], $data['id']);
    }


    /**
     * @param Request $request
     * @param UserService $userService
     * @throws MeteoException
     */
    protected function edit(Request $request, UserService $userService)
    {
        $userService->editUser($request);
    }
}
