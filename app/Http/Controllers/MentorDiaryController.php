<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorDiaryRequest;
use App\Http\Requests\UpdateMentorDiaryRequest;
use App\Services\DiaryInterface;
use Illuminate\Http\Request;

/**
 * Class MentorDiaryController
 * @package App\Http\Controllers
 */
class MentorDiaryController
{
    /**
     * @var DiaryInterface|null
     */
    private $diary = null;

    /**
     * MentorDiaryController constructor.
     * @param DiaryInterface $diary
     */
    public function __construct(DiaryInterface $diary)
    {
        $this->diary = $diary;
    }


    /**
     * @param Request $request
     */
    public function destroy(Request $request): void
    {

        $this->diary->destroy($request->diary_srl, $request->id);
    }

    /**
     * @param UpdateMentorDiaryRequest $request
     * @param int $mentor_srl
     * @param int $diary_srl
     */
    public function update(UpdateMentorDiaryRequest $request, int $mentor_srl, int $diary_srl): void
    {
        $this->diary->update($request, $diary_srl);
    }

    /**
     * @param StoreMentorDiaryRequest $request
     */
    public function store(StoreMentorDiaryRequest $request): void
    {
        $this->diary->create($request);
    }

    /**
     * @param $diary_id
     * @return mixed
     */
    public function show($diary_id)
    {
        $contents = $this->diary->getDiary($diary_id);

        return $contents;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $contents = $this->diary->all();

        return $contents;
    }

    /**
     * @param $mentor_srl
     * @return mixed
     */
    public function mentorDiaries($mentor_srl)
    {

        $contents = $this->diary->userDiary($mentor_srl);

        return $contents;
    }
}
