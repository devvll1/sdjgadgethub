<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUpload
{
    public static function store(?UploadedFile $file, string $directory, ?string $oldFilename = null): ?string
    {
        if (! $file) {
            return null;
        }

        if ($oldFilename) {
            static::delete($directory, $oldFilename);
        }

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->storeAs("public/{$directory}", $filename);

        return $filename;
    }

    public static function delete(string $directory, string $filename): void
    {
        $path = "public/{$directory}/{$filename}";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
