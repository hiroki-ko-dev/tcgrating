<?php

declare(strict_types=1);

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;

final class ImageService
{
    private readonly ImageManager $imageManager;

    public function __construct(?ImageManager $imageManager = null)
    {
        if ($imageManager === null) {
            // ImageManager のインスタンスをデフォルトで作成
            $imageManager = new ImageManager(new Driver());
        }

        $this->imageManager = $imageManager;
    }

    public function save(UploadedFile $file, string $path): array
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time();
        $extension = '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $filename . $extension, 'public');
        $image = $this->imageManager->read('storage/' . $path . '/' . $filename . $extension);
        $encoder = new JpegEncoder(75);
        // 画像をJPEG形式でエンコード
        $encodedImage = $image->encode($encoder);
        $encodedImage->save('storage/' . $path . '/' . $filename . '.jpg');
        // jpg変換前のファイル削除
        Storage::disk('public')->delete($path . '/' . $filename . $extension);

        // 保存されたファイルのURLを返す
        return [$filename . 'jpg', asset('storage/' . $path . '/' . $filename . '.jpg'),];
    }
}
