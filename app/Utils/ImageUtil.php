<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;

final class ImageUtil
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

    public function saveImage(string $fileName, string $directoryPath, string $imageUrl): string
    {
        // URLからファイル取得
        $imgDownloaded = file_get_contents($imageUrl);

        // 保存先のディレクトリパスを設定
        $absoluteDirectoryPath = public_path($directoryPath);

        // ディレクトリが存在しない場合は作成
        if (!file_exists($absoluteDirectoryPath)) {
            mkdir($absoluteDirectoryPath, 0755, true);
        }

        // 保存先のファイルパスを設定
        $filePath = $absoluteDirectoryPath . '/' . $fileName;

        // 画像を直接publicディレクトリに保存
        file_put_contents($filePath, $imgDownloaded);

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($extension !== 'jpg' && $extension !== 'jpeg') {
            $image = $this->imageManager->read($filePath);
            $encoder = new JpegEncoder(75);
            $encodedImage = $image->encode($encoder);
            $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $encodedImage->save($absoluteDirectoryPath . '/' . $fileName);
            // jpg変換前のファイル削除
            unlink($filePath);
        }

        // 保存したファイルへのURLを返す
        return $directoryPath . '/' . $fileName;
    }
}
