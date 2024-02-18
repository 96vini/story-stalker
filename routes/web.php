<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StoryController;

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

Route::get('/', [StoryController::class, 'index']);
Route::post('/', [StoryController::class, 'read'])->name('stories.read');
Route::get('/download', [StoryController::class, 'download'])->name('story.download');
