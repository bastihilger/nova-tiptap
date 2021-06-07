<?php

namespace Manogi\Tiptap;

use Illuminate\Support\Str;

class FileService
{
    public function uniqifyName($name)
    {
        $body = substr($name, 0, strrpos($name, '.'));
        $ext = substr($name, strrpos($name, '.'));

        return $body.'-'.Str::slug(Str::random(6)).$ext;
    }
}
