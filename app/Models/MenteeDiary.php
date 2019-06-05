<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
