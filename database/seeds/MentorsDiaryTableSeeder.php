<?php

use App\Models\MentorDiary;
use Illuminate\Database\Seeder;

class MentorsDiaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //  php artisan make:seeder MentorsDiaryTableSeeder
    public function run()
    {
        factory(MentorDiary::class, 40)->create()->each(function ($fac) {
            $fac->save();
        });
    }
}
