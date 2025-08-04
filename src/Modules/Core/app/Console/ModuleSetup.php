<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Console\Input\InputOption;

abstract class ModuleSetup extends Command
{

    protected function setup(): void
    {
        $commands = [
            'migrate --force',
            'storage:link --force'
        ];
        $this->runCommands($commands);
        $this->info("🔄 Cache کانفیگ ریست و بازسازی شد.");
    }

    protected function cacheClear(): void
    {
        $commands = [
            'optimize',
            'config:clear',
            'event:clear',
            'route:clear',
            'view:clear',
            'optimize:clear',
        ];
        try {
            Redis::ping();
            $commands[] = 'horizon:clear --force';
        } catch (\Throwable $e) {
            $this->warn("❗ Redis در دسترس نیست، horizon:clear اجرا نمی‌شود.");
        }
        $this->runCommands($commands);
    }

    protected function runCommands(array $commands): void
    {
        foreach ($commands as $commandLine) {
            $this->info("➡️ Running: php artisan {$commandLine}");

            $parts = explode(' ', $commandLine);
            $name = array_shift($parts);
            $options = $this->parseOptions($parts);

            try {
                // اجرای migrate اگر وجود داشته باشد
                if ($this->getApplication()->has($name)) {
                    $this->call($name,$options);
                    //$this->cacheClear();
                } else {
                    $this->warn("⛔ دستور {$name} در دسترس نیست.");
                }
            } catch (\Throwable $e) {
                $this->error("⚠️ Failed: {$commandLine}");
                $this->error("   Reason: " . $e->getMessage());
            }

            $this->line(""); // blank line
        }
    }
    private function parseOptions(array $parts): array
    {
        $options = [];

        foreach ($parts as $part) {
            if (str_contains($part, '=')) {
                [$key, $value] = explode('=', $part, 2);
                $options[$key] = $value;
            } else {
                $options[$part] = true;
            }
        }

        return $options;
    }
    protected function updateEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $this->error("❌ فایل .env پیدا نشد.");
            return;
        }

        $envContent = file_get_contents($envPath);

        if (str_contains($envContent, "$key=")) {
            $envContent = preg_replace("/^$key=.*/m", "$key=\"$value\"", $envContent);
            $this->info("🔁 مقدار $key در .env بروزرسانی شد.");
        } else {
            $envContent .= PHP_EOL . "$key=\"$value\"";
            $this->info("➕ کلید $key به .env اضافه شد.");
        }

        file_put_contents($envPath, $envContent);
    }
}
