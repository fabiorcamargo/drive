<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
Route::delete('/files/{id}/{name}', [FileController::class, 'delete'])->name('files.delete');
Route::get('/files/download/{filename}', [FileController::class, 'download'])->name('files.download');
Route::post('file-upload/upload-large-files', [FileUploadController::class, 'uploadLargeFiles'])->name('files.upload.large');
Route::get('stream-video', [VideoController::class, 'streamVideo'])->name('stream.video');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
