<?php


namespace App\Services;

use App\Models\Mentee;
use App\Models\Mentor;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @param string $userType
     * @param string $id
     * @return mixed
     */
    public function getUser(string $userType, string $id)
    {
        if ($userType === "MENTOR") {
            return Mentor::find($id);
        } else {
            return Mentee::find($id);
        }
    }
}
