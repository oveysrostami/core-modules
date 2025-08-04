<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class ModuleInstall extends Command
{
    protected ?string $env = null;

    protected function publishFile($source,$destination): void
    {
        if (!file_exists($source)) {
            $this->warn("📄 فایل پیدا نشد: $source");
            return;
        }
        copy($source, $destination);
        $this->info("$source copied to $destination");
    }
    protected function publishConfigFile(string $sourceRelativePath, string $destinationFilename): void
    {
        $source = module_path($this->getModuleName()) . '/publish/config/' . $sourceRelativePath;
        $destination = config_path($destinationFilename);

        if (!file_exists($source)) {
            $this->warn("📄 فایل config پیدا نشد: $sourceRelativePath");
            return;
        }

        copy($source, $destination);
        $this->info("✅ فایل config/$destinationFilename کپی شد.");
    }

    protected function updateConfigValue(string $filePath, string $search, string $replace): void
    {
        if (!file_exists($filePath)) {
            $this->error("❌ فایل $filePath پیدا نشد.");
            return;
        }

        $content = file_get_contents($filePath);
        $content = str_replace($search, $replace, $content);
        file_put_contents($filePath, $content);

        $this->info("🔧 مقدار config در $filePath بروزرسانی شد.");
    }

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
            $this->info("ℹ️ کلید $key از قبل در .env وجود دارد و تغییری اعمال نشد.");
            return;
        }

        $envContent .= PHP_EOL . "$key=\"$value\"";
        file_put_contents($envPath, $envContent);
        $this->info("➕ کلید $key به .env اضافه شد.");
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['env', null, InputOption::VALUE_OPTIONAL, 'Environment value like local,stage,production', null],
        ];
    }
    function ensurePackageInstalled(string $package , $commands = []): bool
    {
        $composerJsonPath = base_path('composer.json');

        if (!file_exists($composerJsonPath)) {
            echo "⛔ فایل composer.json پیدا نشد.\n";
            return false;
        }

        $composer = json_decode(file_get_contents($composerJsonPath), true);
        $require = $composer['require'] ?? [];
        $requireDev = $composer['require-dev'] ?? [];
        $packageInfo = explode(':',$package);
        if (isset($require[$packageInfo[0]]) || isset($requireDev[$packageInfo[0]])) {
            echo "✅ پکیج {$package} از قبل در composer.json تعریف شده.\n";
            return false;
        }

        echo "🔌 پکیج {$package} در composer.json وجود ندارد. در حال نصب...\n";

        $command = "composer require {$package}";
        $process = proc_open($command, [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes);

        if (is_resource($process)) {
            echo stream_get_contents($pipes[1]); // output
            fclose($pipes[1]);
            echo stream_get_contents($pipes[2]); // errors
            fclose($pipes[2]);
            $status = proc_close($process);

            if ($status === 0) {
                echo "✅ نصب پکیج {$package} با موفقیت انجام شد.\n";
            } else {
                echo "❌ نصب پکیج {$package} با خطا مواجه شد.\n";
            }
        } else {
            echo "⛔ اجرای composer ممکن نشد.\n";
            return false;
        }
        foreach($commands as $command) {
            $this->runInNewProcess($command);
        }
        return true;
        //sleep(5);
        //$this->runInNewProcess('php artisan app:setup '.$this->env);
        //die();
    }

    protected function runInNewProcess(string $command): void
    {
        $process = proc_open($command, [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes);

        if (is_resource($process)) {
            echo stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            echo stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            proc_close($process);
        }
    }
    protected function removeFile($file): void
    {
        if(file_exists($file)){
            unlink($file);
        }
    }
    /**
     * باید در کلاس فرزند override بشه تا اسم ماژول فعلی رو برگردونه
     */
    abstract protected function getModuleName(): string;
}
