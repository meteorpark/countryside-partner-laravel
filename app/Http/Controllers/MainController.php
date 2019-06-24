<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorDiary;
use Illuminate\Http\Request;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        $mentors = Mentor::inRandomOrder()
            ->limit(8)
            ->get();

        return $mentors;
    }

    /**
     * @return mixed
     */
    protected function bestDiaries()
    {
        $diaries = MentorDiary::orderBy('view_count', 'DESC')
            ->orderBy('regdate', 'DESC')
            ->limit(4)
            ->get();

        return $diaries;
    }
}
