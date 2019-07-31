<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChatLists
 *
 * @property int $id
 * @property string $constructor
 * @property string $participants
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatConversation[] $chatLists
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList whereConstructor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList whereParticipants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChatList extends Model
{
    /**
     * @var string
     */
    protected $table = "cp_chat_lists";
    /**
     * @var array
     */
    protected $hidden = ['created_at'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function lastMessage()
    {
        return $this->hasMany(ChatConversation::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getConstructorAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getParticipantsAttribute($value)
    {
        return strtolower($value);
    }

}
