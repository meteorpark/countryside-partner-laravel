<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sns
 * @package App\Models
 */
class Sns extends Model
{
    /**
     * @var string
     */
    protected $table = "cp_sns";
    /**
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @param $value
     * @return string
     */
    public function getTextCreatedAtAttribute($value) : string
    {
        return $this->dateTimeViewer(Carbon::parse($value)->timestamp);
    }

    /**
     * @param $time
     * @return string
     */
    public function dateTimeViewer($time) : string
    {
        $timeLater = time() - $time;
        if ($timeLater < 60) {
            return "방금 전";
        } elseif ($timeLater < 60*60) {
            return floor($timeLater / 60)."분 전";
        } elseif ($timeLater < 60*60*24) {
            return floor($timeLater / (60*60))."시간 전";
        } elseif ($timeLater < 60*60*24*30) {
            return floor($timeLater / (60*60*24))."일 전";
        } else {
            return floor($timeLater / (60*60*24*30))."달 전";
        }
    }
}
