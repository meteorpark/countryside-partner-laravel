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
     * @param $mentor_srl
     * @param $diary_srl
     */
    public function update(UpdateMentorDiaryRequest $request, $mentor_srl, $diary_srl)
    {
        $this->diary->update($request, $diary_srl);
    }

    /**
     * @param StoreMentorDiaryRequest $request
     */
    public function store(StoreMentorDiaryRequest $request)
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
