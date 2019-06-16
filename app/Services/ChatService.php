<?php


namespace App\Services;

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
     * ChatService constructor.
     * @param ChatLists $chatLists
     */
    public function __construct(ChatLists $chatLists)
    {
        $this->chatLists = $chatLists;
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
}
