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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatConversations[] $chatLists
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists whereConstructor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists whereParticipants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatLists whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChatLists extends Model
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
        return $this->hasMany(ChatConversations::class);
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
