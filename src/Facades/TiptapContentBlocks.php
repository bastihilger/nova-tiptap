<?php

namespace Manogi\Tiptap\Facades;

use Illuminate\Support\Facades\Facade;

class TiptapContentBlocks extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tiptap-content-blocks';
    }
}
