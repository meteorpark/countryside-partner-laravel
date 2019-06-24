<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorRequest;
use App\Models\Mentor;
use App\Services\FileUploadService;
use Tymon\JWTAuth\Facades\JWTAuth;

class MentorController extends Controller
{
    /** @var FileUploadService */
    private $fileUploadService;

    /**
     * MentorController constructor.
     * @param FileUploadService $fileUploadService
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @return Mentor[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function index()
    {
        $mentors = Mentor::orderBy('regdate', 'DESC')->paginate(21);//21
        return $mentors;
    }

    /**
     * @param StoreMentorRequest $request
     * @return mixed
     */
    protected function store(StoreMentorRequest $request)
    {
        $data = $request->all();
        $data['profile_image'] = $this->fileUploadService->uploadProfile($request->file('profile_image'));
        $mentor = Mentor::create($data);
        $mentor->setAttribute('token', JWTAuth::fromUser($mentor));

        return $mentor;
    }

    /**
     * @param int $mentor_srl
     * @return Mentor
     */
    protected function view(int $mentor_srl)
    {

        $mentor = Mentor::find($mentor_srl);
        $mentor->setAttribute('srl', $mentor->mentor_srl);
        $mentor->setAttribute('user_type', 'mentor');

        return $mentor;
    }


}
