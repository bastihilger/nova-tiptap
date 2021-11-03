<?php

namespace Manogi\Tiptap\Controllers;

use Facades\Manogi\Tiptap\FileService;
use Illuminate\Support\Facades\Storage;

class ImagesController
{
    public function store()
    {
        $file = request()->file('file');

        $disk = request()->disk;

        if (! $disk) {
            $disk = config('filesystems.disks.public') ? 'public' : config('filesystems.default');
        }

        $path = trim(request()->path) ?: '';

        if (substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }
        if (substr($path, strlen($path) - 1) == '/') {
            $path = substr($path, 0, strlen($path) - 1);
        }

        $fileName = $file->getClientOriginalName();
        if (Storage::disk($disk)->exists($path.'/'.$fileName)) {
            $fileName = FileService::uniqifyName($fileName);
        }

        $newPath = $file->storeAs(
            $path,
            $fileName,
            $disk
        );

        $url = Storage::disk($disk)->url($newPath);

        return [
            'url' => $url,
        ];
    }
}
