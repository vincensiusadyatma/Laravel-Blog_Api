<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PressReleaseController;

// Route::get('/', function () {
//     return view('welcome');
// }) ;

Route::get('/', function () {
    return response()->json([
        'status' => 200,
        'message' => 'API Connected Successfully',
    ], 200);
}) ;

Route::get('/auth/authenticate', function () {
    return view('OauthProxy');
}); 


Route::middleware('guest')->group(function () {
    Route::get('/auth/supabase/google', [AuthController::class, 'redirectToSupabase'])->name('supabase.google');
    Route::get('/auth/supabase/callback', [AuthController::class, 'handleSupabaseCallback'])->name('supabase.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/supabase/logout', [AuthController::class, 'handleSupabaseLogout'])->name('supabase.logout');
});

Route::middleware(['CheckRole:admin'])->prefix('press-releases')->group(function () {
    Route::get('/', [PressReleaseController::class, 'getAlllPress'])->name('press-releases.all'); 
    Route::get('/{pressRelease:press_uuid}', [PressReleaseController::class, 'getPressById'])->name('press-releases.id'); 
    Route::post('/', [PressReleaseController::class, 'store'])->name('press-releases.store'); // Simpan press release baru
    Route::delete('/{pressRelease:press_uuid}', [PressReleaseController::class, 'destroy']);
    Route::put('/{id}', [PressReleaseController::class, 'update'])->name('press-release.update');
    Route::get('/{id}/edit', [PressReleaseController::class, 'edit'])->name('press-release.edit');
});

Route::prefix('gallery')->group(function () {
    Route::get('/', [GalleryController::class, 'getAlllGallery'])->name('gallery.all'); 
    Route::get('/{gallery:gallery_uuid}', [GalleryController::class, 'getGalleryById'])->name('gallery.id'); 
    Route::post('/', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/{gallery:gallery_uuid}', [GalleryController::class, 'destroy'])->name('gallery.destroy'); 
    Route::put('/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::get('/{uuid}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
});

Route::get('/press-release/create', function () {
    return view('pressReleaseView');
});

Route::get('/gallery/bikin/create', function () {

    return view('galleryCreate');
});




