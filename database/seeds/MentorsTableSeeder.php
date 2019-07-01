<?php

use App\Models\Mentor;
use Illuminate\Database\Seeder;


/**
 * Class MentorsTableSeeder
 */
class MentorsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Mentor::class, 30)->create()->each(function ($mentor) {
            $mentor->save();
        });

    }

}
