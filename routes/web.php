<?php

use Illuminate\Support\Facades\Route;

Route::post('/nova-tiptap/api/image', 'Manogi\Tiptap\Controllers\ImagesController@store');
Route::post('/nova-tiptap/api/file', 'Manogi\Tiptap\Controllers\FilesController@store');
