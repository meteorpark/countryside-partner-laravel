<?php


namespace App\Services;

use App\Exceptions\MeteoException;
use App\Models\Mentee;
use App\Models\Mentor;
use Validator;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var FileUploadService|null
     */
    private $fileUploadService = null;

    /**
     * UserService constructor.
     * @param FileUploadService $fileUploadService
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param string $userType
     * @param int $id
     * @return mixed
     */
    public function getUser(string $userType, int $id)
    {
        if ($userType === "MENTOR") {
            return Mentor::find($id);
        } else {
            return Mentee::find($id);
        }
    }

    /**
     * @param $request
     * @throws MeteoException
     */
    public function editUser($request)
    {
        if ($request->user_type === "MENTOR") {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'birthday' => 'required',
                'sex' => 'required|in:male,female',
                'address' => 'required',
                'farm_name' => 'required',
                'career' => 'required',
                'introduce' => 'required',
                'crops' => 'required',
            ]);
            if ($validator->fails()) {
                throw new MeteoException(101, $validator->errors());
            }

            $this->editMentor($request);
        } else {
        }
    }


    /**
     * @param $request
     */
    public function editMentor($request)
    {
        $mentor = Mentor::find($request->id);
        $mentor->name = $request->name;
        $mentor->introduce = $request->introduce;
        $mentor->address = $request->address;
        $mentor->farm_name = $request->farm_name;
        $mentor->career = $request->career;
        $mentor->crops = $request->crops;
        $mentor->sex = $request->sex;
        $mentor->birthday = $request->birthday;

        $image = $this->fileUploadService->uploadProfile($request->file('profile_image'));
        empty($image) ? : $mentor->profile_image = $image;

        $mentor->save();
    }
}
