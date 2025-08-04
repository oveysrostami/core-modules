<?php

namespace Modules\BulkOperation\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\BulkOperation\Models\BulkOperation;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessBulkOperationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $operationId, public bool $applyChanges = false) {}

    public function handle(): void
    {
        $operation = BulkOperation::with('typeModel', 'file')->find($this->operationId);
        if (! $operation) {
            return;
        }

        $operation->update(['status' => 'processing']);

        $file = $operation->file;
        $path = $file->path.'/'.$file->slug.'.'.$file->extension;

        if (! Storage::disk($file->disk)->exists($path)) {
            $operation->update(['status' => 'failed','reason' => 'File not found']);

            return;
        }

        $localPath = $this->downloadFile($file, $path);

        $spreadsheet = IOFactory::load($localPath);
        $rows = array_slice($spreadsheet->getActiveSheet()->toArray(), 1);
        $jobClass = config('bulkoperation.jobs.' . $operation->type);

        if ($jobClass && class_exists($jobClass)) {
            $jobClass::dispatch($operation, $rows, $this->applyChanges);
        } else {
            $operation->update(['status' => 'failed','reason' => 'Job not found']);
        }
        Storage::disk('local')->delete($localPath);
    }

    protected function downloadFile($file,$path): string
    {
        Storage::disk('local')->put("temp_{$file->slug}.{$file->extension}", Storage::disk($file->disk)->get($path));
        return Storage::disk('local')->path("temp_{$file->slug}.{$file->extension}");
    }
}
