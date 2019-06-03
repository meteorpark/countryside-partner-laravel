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
class LoginContoroller extends Controller
{


    /**
     * @param Request $request
     * @return |null
     * @throws MeteoException
     */
    public function login(Request $request)
    {
        $user = null;

        if ($request->is_mentor === true) {

            $user = Mentor::where('id', $request->id)->first();
            $user->setAttribute('srl', $user->mentor_srl);
            $user->setAttribute('user_type', 'mentor');

        } else {

            $user = Mentee::where('id', $request->id)->first();
            $user->setAttribute('srl', $user->mentee_srl);
            $user->setAttribute('user_type', 'mentee');
        }

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
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
