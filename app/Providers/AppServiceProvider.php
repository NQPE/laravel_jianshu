<?php

namespace App\Providers;

use App\Models\Topic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        $this->viewComposer();
    }

    /**
     * 视图合成器
     */
    private function viewComposer(){
        View::composer('layout.sidebar',function($view){
            $topics=Topic::all();
            $view->with(compact('topics'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
