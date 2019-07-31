<?php

namespace App\Observers;

use App\Models\ChatConversation;
use App\Models\Mentee;
use App\Models\Mentor;

class ChatConversationsObserver
{
    /**
     * Handle the chat conversations "created" event.
     *
     * @param  \App\Models\ChatConversation  $chatConversations
     * @return void
     */
    public function created(ChatConversation $chatConversations)
    {
        $expFrom = explode("_", $chatConversations->from);
        $expTo = explode("_", $chatConversations->to);

        if (strtolower($expFrom[0]) === "mentor") {
            Mentor::find($expFrom[1])->decrement('homi');
        } else {
            Mentee::find($expFrom[1])->decrement('homi');
        }

        Mentor::find($expTo[1])->increment('homi'); // 호미추가
    }

    /**
     * Handle the chat conversations "updated" event.
     *
     * @param  \App\Models\ChatConversation  $chatConversations
     * @return void
     */
    public function updated(ChatConversation $chatConversations)
    {
        //
    }

    /**
     * Handle the chat conversations "deleted" event.
     *
     * @param  \App\Models\ChatConversation  $chatConversations
     * @return void
     */
    public function deleted(ChatConversation $chatConversations)
    {
        //
    }

    /**
     * Handle the chat conversations "restored" event.
     *
     * @param  \App\Models\ChatConversation  $chatConversations
     * @return void
     */
    public function restored(ChatConversation $chatConversations)
    {
        //
    }

    /**
     * Handle the chat conversations "force deleted" event.
     *
     * @param  \App\Models\ChatConversation  $chatConversations
     * @return void
     */
    public function forceDeleted(ChatConversation $chatConversations)
    {
        //
    }
}
