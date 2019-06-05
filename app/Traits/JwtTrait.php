<?php
namespace App\Traits;

use App\Models\Mentee;
use App\Models\Mentor;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Auth;
use Exception;

trait JwtTrait
{
    public function useJwt()
    {
        if (app('request')->header('Authorization')) {

            try {

                $jwt = JWTAuth::parseToken()->getPayload();

                if ($jwt->get('user_type') === "MENTOR" && !Mentor::find($jwt->get('id'))) {
                    throw new JWTException('User not found', 404);
                } elseif ($jwt->get('user_type') === "MENTEE" && !Mentee::find($jwt->get('id'))) {
                    throw new JWTException('User not found', 404);
                }

                return $jwt->get('id');

            } catch (Exception $e) {

                return null;
            }
        }

        return null;
    }
}
