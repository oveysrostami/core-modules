<?php

namespace Modules\Test\Console;

use Illuminate\Console\Command;
use Modules\Admin\Models\Admin;
use Modules\Notification\Events\NotificationRequested;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifyTest extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:notify';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $admin = Admin::find(1);
        /*event(new NotificationRequested(
            $admin,
            'in_app',
            'new_event',
            [
                'title'=>'مسیج'
            ],
            [
                'title'=>'پیام جدید'
            ]
        ));*/


        event(new NotificationRequested(
            notifiable: $admin,
            channel: 'telegram',
            templateKey: 'new_event',
            variables: [
                'title' => 'آپدیت مهم محصول منتشر شد!',
            ],
            meta: [
                'chat_id' => '-1002888980212',
            ]));
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
