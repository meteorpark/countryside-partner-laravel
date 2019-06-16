<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class ChatConversations
 * @package App\Models
 */
class ChatConversations extends Model
{
    /**
     * @var array
     */
    protected $hidden = ['updated_at'];
    /**
     * @var string
     */
    protected $table = "cp_chat_conversations";

    public function getCreatedAtAttribute($value)
    {
        return date('D M d Y H:i:s \G\M\TO (T)', strtotime($value));
    }
}
