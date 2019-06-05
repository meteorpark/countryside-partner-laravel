<?php

namespace App\Providers;

use App\Http\Controllers\MenteeDiaryController;
use App\Http\Controllers\MentorDiaryController;
use App\Services\DiaryInterface;
use App\Services\MenteeDiaryService;
use App\Services\MentorDiaryService;
use Illuminate\Support\ServiceProvider;

class BackEndServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(MentorDiaryController::class)->needs(DiaryInterface::class)->give(MentorDiaryService::class);
        $this->app->when(MenteeDiaryController::class)->needs(DiaryInterface::class)->give(MenteeDiaryService::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
