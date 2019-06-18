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
        $this->chatLists->constructor = $from;
        $this->chatLists->participants = $to;
        $this->chatLists->save();

        return $this->chatLists->id;
    }


    /**
     * @param int $chat_lists_id
     * @param string $from
     * @param string $to
     * @param string $message
     * @return int
     */
    public function message(int $chat_lists_id, string $from, string $to, string $message) : int
    {
        $this->chatConversations->chat_lists_id = $chat_lists_id;
        $this->chatConversations->from = $from;
        $this->chatConversations->to = $to;
        $this->chatConversations->message = $message;
        $this->chatConversations->save();

        return $this->chatConversations->id;
    }


    /**
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

            if (strpos($list->constructor, "MENTOR") !== false) {
                $constructor = Mentor::find($expConstructor[1]);
            } elseif (strpos($list->constructor, "MENTEE") !== false) {
                $constructor = Mentee::find($expConstructor[1]);
            }

            if (strpos($list->participants, "MENTOR") !== false) {
                $participant = Mentor::find($expParticipant[1]);
            } elseif (strpos($list->participants, "MENTEE") !== false) {
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
     * @param $user
     * @return mixed
     */
    private function getChatLists($user)
    {
        return ChatLists::orWhere('constructor', $user)->orWhere('participants', $user)->orderBy('updated_at', 'DESC')->with('lastMessage')->get();
    }

}
