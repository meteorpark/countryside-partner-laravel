<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Models\Mentee;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class LoginContoroller
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{

    /**
     * @return mixed
     */
    public function auth(Request $request)
    {
        $auth['srl'] = $request->get('id');
        $auth['user_type'] = strtolower($request->get('user_type'));
        $auth['homi'] = 0;

        if ($request->user_type === "MENTOR") {
            $userInfo = Mentor::find($request->id);
            if ($userInfo) {
                $auth['homi'] = $userInfo->homi;
            }
        } else {
            $userInfo = Mentee::find($request->id);
            if ($userInfo) {
                $auth['homi'] = $userInfo->homi;
            }
        }



        return \Response::success($auth);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws MeteoException
     */
    public function login(Request $request)
    {
        if ($request->is_mentor === 'true') {
            return $this->loginToMentor($request);
        } else {
            return $this->loginToMentee($request);
        }
    }

    /**
     * @param $request
     * @return mixed
     * @throws MeteoException
     */
    public function loginToMentee($request)
    {
        $user = Mentee::where('id', $request->id)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->setAttribute('srl', $user->mentee_srl);
                $user->setAttribute('user_type', 'mentee');
                $user->setAttribute('token', JWTAuth::fromUser($user));
                return $user;
            } else {
                throw new MeteoException(2);
            }
        } else {
            throw new MeteoException(1);
        }
    }

    /**
     * @param $request
     * @return mixed
     * @throws MeteoException
     */
    public function loginToMentor($request)
    {
        $user = Mentor::where('id', $request->id)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->setAttribute('srl', $user->mentor_srl);
                $user->setAttribute('user_type', 'mentor');
                $user->setAttribute('token', JWTAuth::fromUser($user));
                return $user;
            } else {
                throw new MeteoException(2);
            }
        } else {
            throw new MeteoException(1);
        }
    }
}
