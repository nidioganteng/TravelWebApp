<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Kompresi, resize, convert ke WebP, lalu simpan ke storage.
     *
     * @param  UploadedFile  $file  File gambar yang diupload
     * @param  string  $folder  Folder tujuan di storage/public (e.g. 'products')
     * @param  int  $maxWidth  Lebar maksimal dalam pixel (default 1200)
     * @param  int  $quality  Kualitas WebP 0-100 (default 80)
     * @return string Path relatif file yang tersimpan
     */
    public function store(UploadedFile $file, string $folder, int $maxWidth = 1200, int $quality = 80): string
    {
        $filename = Str::uuid().'.webp';
        $path = $folder.'/'.$filename;

        $image = Image::decode($file)
            ->scaleDown(width: $maxWidth)
            ->encode(new WebpEncoder(quality: $quality));

        Storage::disk('public')->put($path, $image->toString());

        return $path;
    }

    /**
     * Hapus file dari storage.
     */
    public function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
