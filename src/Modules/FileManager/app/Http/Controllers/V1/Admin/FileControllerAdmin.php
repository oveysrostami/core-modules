<?php

namespace Modules\FileManager\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\FileManager\Classes\DTO\UploadFileData;
use Modules\FileManager\Http\Requests\FileUploadRequest;
use Modules\FileManager\Models\File;
use Modules\FileManager\Services\FileService;
use Modules\FileManager\Transformers\FileResource;

class FileControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected FileService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(File::query(), $request)
            ->allowedFilters([
                'id',
                'type',
                'mime_type',
                'name',
                'slug',
                'path',
                'extension',
                'size',
                'disk',
                'src',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, FileResource::class);
    }

    public function store(FileUploadRequest $request)
    {
        $data = new UploadFileData(
            file: $request->file('file'),
            disk: config('filemanager.default_disk'),
            path: $request->input('path')
        );
        $file = $this->service->upload($data);
        return $this->success(new FileResource($file));
    }

    public function show(File $file)
    {
        return $this->success(new FileResource($file));
    }

    public function destroy(File $file)
    {
        $this->service->delete($file);
        return $this->success();
    }
}
