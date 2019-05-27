<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Services\NoteInterface;
use Illuminate\Http\Request;

class NoteController extends Controller
{


    /**
     * @param StoreNoteRequest $request
     * @param NoteInterface $note
     */
    public function store(StoreNoteRequest $request, NoteInterface $note)
    {
        $note->create($request);
    }


    public function index()
    {

//        return response()->success();
    }
}
