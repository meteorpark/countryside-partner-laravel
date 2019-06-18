<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Mentee
 *
 * @property int $mentee_srl
 * @property string $id
 * @property string $name
 * @property string $password
 * @property string|null $profile_image
 * @property string $introduce
 * @property string $address
 * @property string|null $phone
 * @property string|null $sex
 * @property string|null $birthday
 * @property int|null $homi
 * @property string|null $crops
 * @property string|null $target_area
 * @property \Illuminate\Support\Carbon $regdate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereCrops($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereHomi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereMenteeSrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mentee whereTargetArea($value)
 * @mixin \Eloquent
 */
class Mentee extends Model implements JWTSubject
{
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
    protected $table = "cp_mentees";
    /**
     * @var string
     */
    protected $primaryKey = "mentee_srl";
    /**
     * @var array
     */
    protected $guarded = []; // 입력된 배열을 제외한 모든 속성들은 대량 할당이 가능하다.
//    protected $fillable = ['name']; // name 를 대량 할당이 가능하다.
//  guarded 혹은 fillable 둘 중에 하나만 써야 함.

    /**
     * @var array
     */
    protected $hidden = ['password', 'phone', 'regdate'];


    /**
     * @param $value
     */
    public function setPasswordAttribute($value){

        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value){

        $this->attributes['phone'] = encrypt($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getProfileImageAttribute($value)
    {
        return empty($value) ? $value = "/images/ico/homi.png" : $value;
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [
            'user_type' => 'MENTEE',
            'id' => $this->mentee_srl,
            'profile_image' => $this->profile_image,
        ];
    }
}
