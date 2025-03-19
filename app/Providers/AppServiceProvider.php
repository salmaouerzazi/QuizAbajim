<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\User;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('web.default.panel.includes.sidebarEnfant', function ($view) {
            $userId = auth()->id();
            $sortedFollowers = DB::table('teachers')
                ->where('users_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($follower) {
                    $follower->followerUser = User::find($follower->teacher_id);
                    return $follower;
                });
                $view->with('sortedFollowers', $sortedFollowers);
            $hasSubscribePack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->exists();
            $view->with('hasSubscribePack', $hasSubscribePack);
            $subscribedPack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->first();

            if ($hasSubscribePack) {
                $pack = \App\Models\Subscribe::query()
                ->where('id', $subscribedPack->model_id)
                ->first();
            $view->with('pack', $pack);
            }
            
        });
    }
}
