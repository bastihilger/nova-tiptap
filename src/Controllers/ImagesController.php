<?php

namespace Manogi\Tiptap\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImagesController
{
    public function store()
    {
        $file = request()->file('file');
        $disk = request()->disk ?: config('filesystem.default');
        $path = trim(request()->path) ?: '';


        $fileName = $this->uniqifyName($file->getClientOriginalName());

        if (substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }
        if (substr($path, strlen($path)-1) == '/') {
            $path = substr($path, 0, strlen($path)-1);
        }

        $fileName = $file->getClientOriginalName();
        if (Storage::disk($disk)->exists($path.'/'.$fileName)) {
            $fileName = $this->uniqifyName($fileName);
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

    protected function uniqifyName($name)
    {
        $body = substr($name, 0, strrpos($name, '.'));
        $ext = substr($name, strrpos($name, '.'));

        return $body.'-'.Str::slug(Str::random(6)).$ext;
    }
}
