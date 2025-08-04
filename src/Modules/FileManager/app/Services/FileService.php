<?php

namespace Modules\FileManager\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Core\Exceptions\ApiException;
use Modules\FileManager\Classes\DTO\UploadFileData;
use Modules\FileManager\Events\FileUploaded;
use Modules\FileManager\Models\File;

class FileService
{
    /**
     * @throws ApiException
     */
    public function upload(UploadFileData $data): File
    {
        $content = file_get_contents($data->file->getRealPath());
        $extension = strtolower($data->file->getClientOriginalExtension());
        $mime = $data->file->getClientMimeType();

        return $this->storeContent(
            $content,
            $data->file->getClientOriginalName(),
            $extension,
            $mime,
            $data->path,
            $data->disk
        );
    }

    /**
     * @throws ApiException
     */
    public function storeContent(string $content, string $originalName, string $extension, string $mime, ?string $path, string $disk): File
    {
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $slug = Str::slug($nameWithoutExt);
        $directory = $path ? trim($path, '/') : now()->format('Y/m/d');

        $finalSlug = $slug;
        $i = 1;
        $fullPath = ($directory ? $directory.'/' : '').$finalSlug.'.'.$extension;
        try {
            while (Storage::disk($disk)->exists($fullPath)) {
                $finalSlug = $slug . '-' . $i;
                $i++;
                $fullPath = ($directory ? $directory . '/' : '') . $finalSlug . '.' . $extension;
            }

            Storage::disk($disk)->put($fullPath, $content);

            $file = File::create([
                'type' => $this->detectType($extension),
                'mime_type' => $mime,
                'name' => $nameWithoutExt,
                'slug' => $finalSlug,
                'path' => $directory,
                'extension' => $extension,
                'size' => strlen($content),
                'disk' => $disk,
            ]);

            event(new FileUploaded($file));

            return $file;
        }catch (\Exception $exception){
            throw new ApiException('server.exception_error',['message'=>$exception->getMessage()],'500','core');
        }
    }

    public function delete(File $file): void
    {
        $fullPath = ($file->path ? $file->path.'/' : '').$file->slug.'.'.$file->extension;
        Storage::disk($file->disk)->delete($fullPath);
        $file->delete();
    }

    private function detectType(string $extension): string
    {
        return match($extension) {
            'jpg','jpeg','png','gif','webp','svg' => 'image',
            'mp4','mkv','avi' => 'video',
            'mp3','wav' => 'audio',
            'txt' => 'text',
            'zip' => 'zip',
            'xlsx','xls' => 'excel',
            'pdf' => 'pdf',
            'doc' => 'doc',
            'docx' => 'docx',
            'ppt' => 'ppt',
            'pptx' => 'pptx',
            default => 'file',
        };
    }
}
