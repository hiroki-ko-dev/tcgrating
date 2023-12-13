<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\Image\ImageService;

final class ImageController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
    }

    public function ckeditorUpload(Request $request): Response | HttpResponseException
    {
        if (!$request->hasFile('upload')) {
            throw new HttpResponseException(response()->json([
                'uploaded' => 0, 'error' => ['message' => 'アップロードファイルが見つかりません。']
            ], Response::HTTP_BAD_REQUEST));
        }

        try {
            $file = $request->file('upload');
            [$filename, $url] = $this->imageService->save($file, 'blog/images');
            return response()->json(['uploaded' => 1, 'fileName' => $filename, 'url' => $url]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0, 'error' => ['message' => 'ファイルをアップロードできませんでした。'
                ]], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
