<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MenteeDiary
 *
 * @property int $diary_srl
 * @property int $mentee_srl
 * @property string $title
 * @property string|null $image
 * @property string $contents
 * @property int $view_count
 * @property int $like_count
 * @property string $regdate
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Mentee $mentee
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenteeDiary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereDiarySrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereLikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereMenteeSrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenteeDiary whereViewCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenteeDiary withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenteeDiary withoutTrashed()
 * @mixin \Eloquent
 */
class MenteeDiary extends Model
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
    protected $table = "cp_mentees_diary";
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
     * @param $value
     * @return string
     */
    public function getRegdateAttribute($value)
    {
        $regdate = Carbon::parse($value);

        return $regdate->format('Y-m-d H:i');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentee()
    {
        return $this->belongsTo(Mentee::class, 'mentee_srl');
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
