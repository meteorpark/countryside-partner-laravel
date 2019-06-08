<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorDiaryRequest;
use App\Http\Requests\UpdateMentorDiaryRequest;
use App\Services\DiaryInterface;
use Illuminate\Http\Request;

/**
 * Class MenteeDiaryController
 * @package App\Http\Controllers
 */
class MenteeDiaryController extends Controller
{
    /**
     * @var DiaryInterface|null
     */
    private $diary = null;

    /**
     * MenteeDiaryController constructor.
     * @param DiaryInterface $diary
     */
    public function __construct(DiaryInterface $diary)
    {
        $this->diary = $diary;
    }

    /**
     * @param StoreMentorDiaryRequest $request
     */
    public function store(StoreMentorDiaryRequest $request): void
    {
        $this->diary->create($request);
    }

    /**
     * @param $mentee_srl
     * @return mixed
     */
    public function menteeDiaries($mentee_srl)
    {
        $contents = $this->diary->userDiary($mentee_srl);

        return $contents;
    }

    /**
     * @param $mentee_srl
     * @param $diary_id
     * @return mixed
     */
    public function show($mentee_srl, $diary_id)
    {
        $contents = $this->diary->getDiary($diary_id);

        return $contents;
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
}
