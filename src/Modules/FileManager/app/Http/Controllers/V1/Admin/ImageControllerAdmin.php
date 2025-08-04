<?php

namespace Modules\FileManager\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use ImagickException;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\FileManager\Classes\DTO\UploadImageData;
use Modules\FileManager\Http\Requests\ImageUploadRequest;
use Modules\FileManager\Models\Image;
use Modules\FileManager\Services\ImageService;
use Modules\FileManager\Transformers\ImageResource;

class ImageControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected ImageService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(Image::query()->with('file'), $request)
            ->allowedFilters([
                'id',
                'width',
                'height',
                'alt',
                'priority',
                'src',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, ImageResource::class);
    }

    /**
     * @throws ImagickException
     * @throws ApiException
     */
    public function store(ImageUploadRequest $request)
    {
        $data = new UploadImageData(
            file: $request->file('file'),
            disk: config('filemanager.public_disk'),
            path: $request->input('path'),
            width: $request->input('width'),
            height: $request->input('height'),
            quality: $request->input('quality'),
            alt: $request->input('alt'),
            priority: $request->input('priority')
        );
        $image = $this->service->upload($data);
        return $this->success(new ImageResource($image));
    }

    public function show(Image $image)
    {
        $image->load('file');
        return $this->success(new ImageResource($image));
    }

    public function destroy(Image $image)
    {
        $this->service->delete($image);
        return $this->success();
    }
}
