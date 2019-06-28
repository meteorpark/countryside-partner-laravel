<?php

namespace App\Providers;

use App\Models\ChatConversations;
use App\Observers\ChatConversationsObserver;
use Illuminate\Support\ServiceProvider;
use Thujohn\Twitter\TwitterServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }




        $this->app->register(ResponseMacroServiceProvider::class);
        $this->app->register(TwitterServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        ChatConversations::observe(ChatConversationsObserver::class); //  호미차감
    }
}
