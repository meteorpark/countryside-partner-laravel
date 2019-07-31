<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class ChatConversations
 * @package App\Models
 */
class ChatConversation extends Model
{
    /**
     * @var string
     */
    protected $table = "cp_chat_conversations";
    /**
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * @var array
     */
    protected $touches = ['parentUpdatedAt'];

    /**
     * @param $value
     * @return false|string
     */
    public function getCreatedAtAttribute($value)
    {
        return date('D M d Y H:i:s \G\M\TO (T)', strtotime($value));
    }

    /**
     * 채팅방목록 시간 변경
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentUpdatedAt()
    {
        return $this->belongsTo(ChatList::class, 'chat_lists_id');
    }
}
