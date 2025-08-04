<?php

namespace Modules\FileManager\Services;

use Exception;
use Imagick;
use ImagickException;
use Modules\Core\Exceptions\ApiException;
use Modules\FileManager\Classes\DTO\UploadImageData;
use Modules\FileManager\Events\ImageUploaded;
use Modules\FileManager\Models\Image;

class ImageService
{
    public function __construct(protected FileService $fileService)
    {
    }

    /**
     * @throws ImagickException
     * @throws ApiException
     */
    public function upload(UploadImageData $data): Image
    {
        $imagick = new Imagick($data->file->getRealPath());

        if ($data->width || $data->height) {
            $imagick->resizeImage($data->width ?? 0, $data->height ?? 0, Imagick::FILTER_LANCZOS, 1, true);
        }
        if ($data->quality) {
            $imagick->setImageCompressionQuality($data->quality);
        }

        $extension = strtolower($data->file->getClientOriginalExtension());
        $mime = $data->file->getClientMimeType();

        if ($extension !== 'svg') {
            try {
                $imagick->setImageFormat('webp');
                $extension = 'webp';
                $mime = 'image/webp';
            } catch (Exception $e) {
                // keep original format
            }
        }

        $content = $imagick->getImagesBlob();

        $file = $this->fileService->storeContent(
            $content,
            $data->file->getClientOriginalName(),
            $extension,
            $mime,
            $data->path,
            $data->disk
        );

        $image = Image::create([
            'file_id' => $file->id,
            'width' => $imagick->getImageWidth(),
            'height' => $imagick->getImageHeight(),
            'alt' => $data->alt,
            'priority' => $data->priority ?? 1,
        ]);

        event(new ImageUploaded($image));

        return $image;
    }

    public function delete(Image $image): void
    {
        $this->fileService->delete($image->file);
    }
}
