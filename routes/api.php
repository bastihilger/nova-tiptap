<?php

use Illuminate\Support\Facades\Route;
use acoglezrojo\Tiptap\Controllers\FilesController;
use acoglezrojo\Tiptap\Controllers\ImagesController;

Route::post('file', FilesController::class.'@store');
Route::post('image', ImagesController::class.'@store');
