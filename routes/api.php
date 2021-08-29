<?php

use Illuminate\Support\Facades\Route;
use Manogi\Tiptap\Controllers\FilesController;
use Manogi\Tiptap\Controllers\ImagesController;

Route::post('file', FilesController::class.'@store');
Route::post('image', ImagesController::class.'@store');
