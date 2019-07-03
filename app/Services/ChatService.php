<?php


namespace App\Services;

use App\Models\ChatConversations;
use App\Models\ChatLists;
use App\Models\Mentee;
use App\Models\Mentor;

/**
 * Class ChatService
 * @package App\Services
 */
class ChatService
{
    /**
     * @var ChatLists|null
     */
    private $chatLists = null;
    /**
     * @var ChatConversations|null
     */
    private $chatConversations = null;

    /**
     * ChatService constructor.
     * @param ChatLists $chatLists
     * @param ChatConversations $chatConversations
     */
    public function __construct(ChatLists $chatLists, ChatConversations $chatConversations)
    {
        $this->chatLists = $chatLists;
        $this->chatConversations = $chatConversations;
    }

    /**
     * @param string $from
     * @param string $to
     * @return int
     */
    public function createChatRoom(string $from, string $to) : int
    {
        $chatId = $this->isChat($from, $to);

        if ($chatId === false) {
            $this->chatLists->constructor = $from;
            $this->chatLists->participants = $to;
            $this->chatLists->save();

            return $this->chatLists->id;
        } else {
            return $chatId;
        }
    }

    /**
     * 채팅중인지 확인
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function isChat(string $from, string $to)
    {
        $chat = ChatLists::where('constructor', $from)->where('participants', $to)->first();

        if (!$chat) {
            return false;
        }
        return $chat->id;
    }

    /**
     * @param string $chat_lists_id
     * @param string $from
     * @param string $to
     * @param string $message
     * @return string
     */
    public function message(string $chat_lists_id, string $from, string $to, string $message) : string
    {
        $this->chatConversations->chat_lists_id = $chat_lists_id;
        $this->chatConversations->from = $from;
        $this->chatConversations->to = $to;
        $this->chatConversations->message = $message;
        $this->chatConversations->save();

        return $this->chatConversations->id;
    }


    /**
     * 대화내요 가져오기
     * @param $user
     * @return mixed
     */
    public function chatLists($user)
    {
        $lists = $this->getChatLists($user);

        // TODO : DB설계 다시 해야 함.
        foreach ($lists as $list) {
            $constructor = null;
            $participant = null;

            $expConstructor = explode("_", $list->constructor);
            $expParticipant = explode("_", $list->participants);

            if (strpos($list->constructor, "mentor") !== false) {
                $constructor = Mentor::find($expConstructor[1]);
            } elseif (strpos($list->constructor, "mentee") !== false) {
                $constructor = Mentee::find($expConstructor[1]);
            }

            if (strpos($list->participants, "mentor") !== false) {
                $participant = Mentor::find($expParticipant[1]);
            } elseif (strpos($list->participants, "mentee") !== false) {
                $participant = Mentee::find($expParticipant[1]);
            }
            $list->setAttribute('constructor_image', $constructor ? $constructor->profile_image : "");
            $list->setAttribute('constructor_name', $constructor ? $constructor->name : "");
            $list->setAttribute('participants_image', $participant ? $participant->profile_image : "");
            $list->setAttribute('participants_name', $participant ? $participant->name : "");
        }

        return $lists;
    }

    /**
     * 채팅방 리스트 가져오기
     * @param $user
     * @return mixed
     */
    private function getChatLists($user)
    {
        return ChatLists::orWhere('constructor', $user)->
                        orWhere('participants', $user)->
                        orderBy('updated_at', 'DESC')->
                        with(['lastMessage' => function ($query) {
                            $query->orderBy('created_at', 'DESC')->groupBy('chat_lists_id');
                        }])->
                        get();
    }

    /**
     * 메세지 전송하기
     * @param array $data
     * @return string
     */
    public function sendMessage(array $data)
    {
        $chat_lists_id = null;

        if (empty($data['chat_lists_id'])) { // 채팅방 신규생성

            $chat_lists_id = $this->createChatRoom($data['from'], $data['to']);
        } else {
            $chat_lists_id = $data['chat_lists_id'];
        }

        return $this->message($chat_lists_id, $data['from'], $data['to'], $data['message']);
    }
}
