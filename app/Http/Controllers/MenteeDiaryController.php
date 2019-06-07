<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorDiaryRequest;
use App\Services\DiaryInterface;
use Illuminate\Http\Request;

class MenteeDiaryController extends Controller
{
    private $diary = null;

    public function __construct(DiaryInterface $diary)
    {
        $this->diary = $diary;
    }

    public function store(StoreMentorDiaryRequest $request): void
    {
        $this->diary->create($request);
    }

    public function menteeDiaries($mentee_srl)
    {
        $contents = $this->diary->userDiary($mentee_srl);

        return $contents;
    }
}
