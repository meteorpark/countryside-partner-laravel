<?php


namespace App\Services;

use App\Models\ChatConversations;
use App\Models\ChatLists;

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
}
