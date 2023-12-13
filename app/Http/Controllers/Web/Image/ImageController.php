<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ImageController extends Controller
{
    public function ckeditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            // 保存用ファイル名を生成
            $storeFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) .
                '_' . time() . '.' .
                $file->getClientOriginalExtension();

            // アップロード処理（'public' ディスクを指定）
            $file->storeAs('blog/images', $storeFilename, 'public');

            // ckeditor.jsに返却するデータを生成する
            $url = asset('storage/blog/images/' . $storeFilename); // URLの生成

            // JSON応答を返す
            return response()->json(['uploaded' => 1, 'fileName' => $storeFilename, 'url' => $url]);
        }

        // アップロードに失敗した場合の応答
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'ファイルをアップロードできませんでした。']]);
    }
}
