<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return view('welcome');
// });

Route::middleware(['auth'])->group(function () {
    Route::controller(FileController::class)->group(function () {
        Route::get('/', 'list')->name('files.index');
        Route::post('/files', 'upload')->name('files.store');
        Route::get('/files/download/{id}', 'download')->name('files.download');
        Route::get('/files/{id}', 'show')->name('files.show');
        Route::put('/files/{id}', 'update')->name('files.update');
        Route::delete('/files/{id}', 'delete')->name('files.delete');
    });
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
