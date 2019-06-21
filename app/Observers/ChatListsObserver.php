<?php

namespace App\Observers;

use App\Models\ChatLists;
use App\Models\Mentee;
use App\Models\Mentor;

class ChatListsObserver
{
    /**
     * Handle the chat lists "created" event.
     *
     * @param  \App\Models\ChatLists  $chatLists
     * @return void
     */
    public function created(ChatLists $chatLists)
    {
        $expConstructor = explode("_", $chatLists->constructor);
        $expParticipant = explode("_", $chatLists->participants);

        if ($expConstructor[0] === "MENTOR") {
            Mentor::find($expConstructor[1])->decrement('homi');
        } else {
            Mentee::find($expConstructor[1])->decrement('homi');
        }

        Mentor::find($expParticipant[1])->increment('homi'); // 호미추가
    }

    /**
     * Handle the chat lists "updated" event.
     *
     * @param  \App\Models\ChatLists  $chatLists
     * @return void
     */
    public function updated(ChatLists $chatLists)
    {
        //
    }

    /**
     * Handle the chat lists "deleted" event.
     *
     * @param  \App\Models\ChatLists  $chatLists
     * @return void
     */
    public function deleted(ChatLists $chatLists)
    {
        //
    }

    /**
     * Handle the chat lists "restored" event.
     *
     * @param  \App\Models\ChatLists  $chatLists
     * @return void
     */
    public function restored(ChatLists $chatLists)
    {
        //
    }

    /**
     * Handle the chat lists "force deleted" event.
     *
     * @param  \App\Models\ChatLists  $chatLists
     * @return void
     */
    public function forceDeleted(ChatLists $chatLists)
    {
        //
    }
}
