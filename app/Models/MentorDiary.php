<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MentorDiary
 *
 * @package App\Models
 * @property int $diary_srl
 * @property int $mentor_srl
 * @property string $title
 * @property string|null $image
 * @property string $contents
 * @property int $view_count
 * @property int $like_count
 * @property string $regdate
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Mentor $mentor
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MentorDiary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereDiarySrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereLikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereMentorSrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MentorDiary whereViewCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MentorDiary withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MentorDiary withoutTrashed()
 * @mixin \Eloquent
 */
class MentorDiary extends Model
{
    use SoftDeletes;
    /**
     *
     */
    const CREATED_AT = 'regdate';
    /**
     *
     */
    const UPDATED_AT = null;


    /**
     * @var string
     */
    protected $table = "cp_mentors_diary";
    /**
     * @var string
     */
    protected $primaryKey = "diary_srl";
    /**
     * @var array
     */
    protected $guarded = []; // name을 제외한 모든 속성들은 대량 할당이 가능하다.
//    protected $fillable = ['name']; // name, 를 대량 할당이 가능하다. guarded 혹은 fillable 둘 중에 하나만 써야 함.

    /**
     * @var array
     */
    protected $hidden = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_srl');
    }


    /**
     * @param $value
     * @return string
     */
    public function getRegdateAttribute($value)
    {
        $regdate = Carbon::parse($value);

        return $regdate->format('Y-m-d H:i');
    }

    /**
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if ($value !== "File not allowed") {
            $this->attributes['image'] = $value;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            $value = config('nclound.ncloud_object_storage_host')."/".$value;
        }

        return $value;
    }


}
