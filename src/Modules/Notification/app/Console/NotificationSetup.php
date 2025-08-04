<?php

namespace Modules\Notification\Console;

use Modules\Core\Console\ModuleSetup;
use Modules\Notification\Models\NotificationProvider;
use Modules\Notification\Models\NotificationTemplate;

class NotificationSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notification:setup';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        NotificationProvider::updateOrCreate(
            [
                'name' => 'internal_database'
            ],
            [
                'channel' => 'in_app',
                'config' => [],
                'weight' => 100,
                'forced_for_templates' => [],
            ]
        );
        NotificationProvider::updateOrCreate(
            [
                'name' => 'farazsms'
            ],
            [
                'channel' => 'sms',
                'config' => ['token' => 'OWY3ZjljMzUtYmNkZi00NTI2LTkwMTEtZDU3ZTJmNGNmNTVhNWE4NzVjNjFkMWRhYmVmNjc3NjViMDEwMzg2MDZjYzM='],
                'weight' => 100,
                'forced_for_templates' => [],
            ]
        );
        NotificationProvider::updateOrCreate(
            [
                'name' => 'smsir'
            ],
            [
                'channel' => 'sms',
                'config' => ['token' => ''],
                'weight' => 100,
                'forced_for_templates' => [],
            ]
        );
        NotificationProvider::updateOrCreate(
            [
                'name' => 'kavehnegar'
            ],
            [
                'channel' => 'sms',
                'config' => ['token' => '48584C43496C473871375469314865715568666C3134795A7749767754413078'],
                'weight' => 100,
                'forced_for_templates' => [],
            ]
        );
        NotificationProvider::updateOrCreate(
            [
                'name' => 'telegram_notification_bot'
            ],
            [
                'channel' => 'telegram',
                'config' => ['token' => '8296245410:AAG3thIeDP9McbMwFyjGl4sCz63Mc-35ItQ'],
                'weight' => 100,
                'forced_for_templates' => [],
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_in_approved',
            ],
            [
                'content' => 'کاربر گرامی مبلغ {{amount}} برای شما واریز شد'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_in_failed',
            ],
            [
                'content' => 'درخواست واریز شما با شناسه {id} و مبلغ {amount} ناموفق بود'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_in_canceled',
            ],
            [
                'content' => 'درخواست واریز شما با شناسه {id} و مبلغ {amount} کنسل شد'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_in_rejected',
            ],
            [
                'content' => 'درخواست واریز شما با شناسه {id} و مبلغ {amount} تایید نشد.'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_out_rejected',
            ],
            [
                'content' => 'درخواست برداشت شما با شناسه {id} و مبلغ {amount} تایید نشد.'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_out_failed',
            ],
            [
                'content' => 'درخواست برداشت شما با شناسه {id} و مبلغ {amount} ناموفق بود'
            ]
        );
        NotificationTemplate::updateOrCreate(
            [
                'channel' => 'in_app',
                'key' => 'wallet_cash_out_approved',
            ],
            [
                'content' => 'کاربر گرامی مبلغ {{amount}} از حساب شما برداشت شد'
            ]
        );
    }

    protected function getModuleName(): string
    {
        return 'Admin';
    }
}
