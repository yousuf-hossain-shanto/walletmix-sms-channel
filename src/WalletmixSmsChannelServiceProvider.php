<?php
namespace YHShanto\WalletmixSMS;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class WalletmixSmsChannelServiceProvider extends ServiceProvider
{
    /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            Notification::resolved(function (ChannelManager $service) {
                $service->extend('walletmix', function ($app) {
                    return new Channels\WalletmixSmsChannel($this->app['config']['services.walletmix.sms']);
                });
            });
        }
}
