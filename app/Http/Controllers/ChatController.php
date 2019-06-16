<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Models\ChatLists;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    private $chatService = null;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }


    protected function store(Request $request)
    {
        if (empty($request->chat_lists_id)) { // 채팅방 신규생성

            $id = $this->chatService->createChatRoom($request->from, $request->to);

        }


//        $data = $request->all();
//        $data['profile_image'] = $this->fileUploadService->uploadProfile($request->file('profile_image'));
//        $mentor = Mentor::create($data);
//        $mentor->setAttribute('token', JWTAuth::fromUser($mentor));
//        return $mentor;


    }
}
