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
Route::get('/download-video', [StoryController::class, 'downloadVideo'])->name('story.downloadVideo');
Route::get('/download-image', [StoryController::class, 'downloadImage'])->name('story.downloadImage');


/**
 * SEO Routes
 */
Route::get('/watch-stories-anonymous', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/watch-stories', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/download-stories', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/anonymous-stories', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/see-stories-instagram', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/watch-instagram', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/watch-instagram-anonymous', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/see-stories-anonymous', [StoryController::class, 'SeoPageEn'])->name('story.SeoPage');
Route::get('/assistir-stories-anonimamente', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/ver-stories-anonimo', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/ver-stories-anonimo-instagram', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/assistir-stories-anonimo-instagram', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/assistir-stories-instagram', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/baixar-stories-instagram', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
Route::get('/baixar-stories', [StoryController::class, 'SeoPagePt'])->name('story.SeoPage');
