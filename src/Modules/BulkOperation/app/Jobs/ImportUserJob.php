<?php

namespace Modules\BulkOperation\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\BulkOperation\Models\BulkOperation;
use Modules\User\Classes\DTO\CreateUserData;
use Modules\User\Models\User;
use Modules\User\Services\UserService;

class ImportUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public BulkOperation $operation, public array $rows, public bool $applyChanges = false) {}

    public function handle(): void
    {
        $index = 0;
        $success = 0;
        $failure = 0;
        \Log::info("Importing users");
        foreach ($this->rows as $row) {
            $index++;
            try {
                [$firstName, $lastName, $email, $mobile] = [$row[0] ?? null, $row[1] ?? null, $row[2] ?? null, $row[3] ?? null];

                if (! $firstName || ! $email || ! $mobile) {
                    throw new \Exception('invalid_row');
                }

                if ($this->applyChanges) {
                    $userService = new UserService();
                    $userService->create(new CreateUserData($firstName, $lastName, $email, $mobile,\Str::random(10)));
                }

                $this->operation->results()->create([
                    'index' => $index,
                    'row_data' => $row,
                    'status' => 'success',
                    'message' => $this->applyChanges ? 'applied' : 'validated',
                ]);
                $success++;
            } catch (\Throwable $e) {
                $this->operation->results()->create([
                    'index' => $index,
                    'row_data' => $row,
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
                $failure++;
            }
        }

        $this->operation->update([
            'total' => $index,
            'success' => $success,
            'failure' => $failure,
            'status' => $this->applyChanges ? 'completed' : ($this->operation->typeModel?->requires_admin_approval ? 'waiting_admin' : 'completed'),
        ]);
    }
}
