<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


//设置第三方登录
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        SocialiteWasCalled::class => [        
             \SocialiteProviders\WeixinWeb\WeixinWebExtendSocialite::class,    
         ],
        //'SocialiteProviders\Manager\SocialiteWasCalled' => [
        //    'SocialiteProviders\WeixinWeb\WeixinWebExtendSocialite@handle',
        //],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
