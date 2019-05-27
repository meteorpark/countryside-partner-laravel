<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorDiaryRequest;
use App\Services\DiaryInterface;

class MentorDiaryController
{
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
    public function mentorArticles($mentor_srl)
    {
        $contents = $this->diary->userDiary($mentor_srl);

        return $contents;
    }
}
