<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Http\Requests\StoreChatRequest;
use App\Models\ChatConversations;
use App\Models\ChatLists;
use App\Models\Mentee;
use App\Models\Mentor;
use App\Services\ChatService;
use Illuminate\Http\Request;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * @var ChatService|null
     */
    private $chatService = null;

    /**
     * ChatController constructor.
     * @param ChatService $chatService
     */
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    /**
     * @param StoreChatRequest $request
     * @return mixed
     */
    protected function store(StoreChatRequest $request)
    {
        $chat_lists_id = null;
        $data = $request->all();
        if (empty($data['chat_lists_id'])) { // 채팅방 신규생성
            $chat_lists_id = $this->chatService->createChatRoom($data['from'], $data['to']);
        } else {
            $chat_lists_id = $data['chat_lists_id'];
        }

        $message_id = $this->chatService->message($chat_lists_id, $data['from'], $data['to'], $data['message']);

        return $this->show($message_id);
    }
    /**
     * @param $message_id
     * @return mixed
     */
    protected function show($message_id)
    {
        return ChatConversations::find($message_id);
    }

    /**
     * @param $chat_lists_id
     * @return mixed
     */
    protected function messagelists($chat_lists_id)
    {
        $conversations = ChatConversations::where('chat_lists_id', $chat_lists_id)->orderBy('created_at', 'DESC')->paginate(15);

        return $conversations;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function chatLists(Request $request)
    {
        $data = $request->all();
        $user = $data['user_type']."_".$data['id'];
        return $this->chatService->chatLists($user);
    }
}
