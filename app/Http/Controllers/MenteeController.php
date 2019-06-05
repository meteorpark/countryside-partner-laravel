<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenteeRequest;
use App\Models\Mentee;
use App\Services\FileUploadService;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class MenteeController
 * @package App\Http\Controllers
 */
class MenteeController extends Controller
{
    /** @var FileUploadService */
    private $fileUploadService;

    /**
     * MenteeController constructor.
     * @param FileUploadService $fileUploadService
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param StoreMenteeRequest $request
     * @return mixed
     */
    protected function store(StoreMenteeRequest $request)
    {
        $data = $request->all();

        $data['profile_image'] = $this->fileUploadService->uploadProfile($request->file('profile_image'));
        $mentee = Mentee::create($data);
        $mentee->setAttribute('token', JWTAuth::fromUser($mentee));

        return $mentee;
    }

    /**
     * @return Mentee[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function index()
    {
        $mentees = Mentee::all();
        return $mentees;
    }

    /**
     * @param int $mentee_srl
     * @return mixed
     */
    protected function view(int $mentee_srl)
    {

        $mentee = Mentee::find($mentee_srl);
        $mentee->setAttribute('srl', $mentee->mentee_srl);
        $mentee->setAttribute('user_type', 'mentee');

        return $mentee;
    }
}
