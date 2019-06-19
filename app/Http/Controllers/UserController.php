<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected function userInfo(Request $request, UserService $userService)
    {
        $data = $request->all();

        return $userService->getUser($data['user_type'], $data['id']);
    }
}
