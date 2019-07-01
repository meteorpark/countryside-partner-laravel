<?php

use App\Models\Mentee;
use Illuminate\Database\Seeder;

class MenteesTableSeeder extends Seeder
{
    // php artisan make:seeder UsersTableSeeder

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Mentee::class, 30)->create()->each(function ($mentee) {
            $mentee->save();
        });
    }
}
