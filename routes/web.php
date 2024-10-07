<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FolderController;
use App\Models\DocApproval;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DocApprovalController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
//
//     // Route::get('/search', function () {
//     //     return view('search');
//     // })->name('search');
//     Route::get('/search', [EntryController::class, 'index'])->name('search');
//
//
//     Route::get('/folder', [FolderController::class, 'index'])->name('folder');
//     Route::post('/folder/store', [FolderController::class, 'store'])->name('folder.store');
//
//     Route::get('/folder/create', function () {
//         return view('folder-create');
//     })->name('folder-create');
//
//     // Route::get('/custom-field', function () {
//     //     return view('custom-field');
//     // })->name('custom-field');
//     Route::get('/custom-field', [CustomFieldController::class, 'index'])->name('custom-field');
//     Route::post('/custom-field', [CustomFieldController::class, 'store'])->name('custom-field.store');
//
//     // Route::get('/entry-data', function () {
//     //     return view('entry-data');
//     // })->name('entry-data');
//     // Route untuk menampilkan formulir
//     // Route::get('/entry-data', function () {
//     //     return view('entry-data'); // Pastikan ini sesuai dengan nama file view Anda
//     // })->name('entry-data');
//     Route::get('/entry-data', [EntryController::class, 'create'])->name('entry-data');
//
//
//     // Route untuk menyimpan data
//     Route::post('/entry-data', [EntryController::class, 'store'])->name('entry-data.store');
//     Route::get('/entry-data/edit/{id}', [EntryController::class, 'edit'])->name('entry-data.edit');
//     Route::put('/entry-data/{id}', [EntryController::class, 'update'])->name('entry-data.update');
// });
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute yang sudah ada
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/folder', [FolderController::class, 'index'])->name('folder');
    Route::post('/folder/store', [FolderController::class, 'store'])->name('folder.store');
    Route::get('/folder/create', function () {
        return view('folder-create');
    })->name('folder-create');

    Route::get('/folder/edit/{id}', [FolderController::class, 'edit'])->name('folder.edit');
    Route::put('/folder/update/{id}', [FolderController::class, 'update'])->name('folder.update');
    Route::delete('/folder/destroy/{id}', [FolderController::class, 'destroy'])->name('folder.destroy');


    Route::get('/custom-field', [CustomFieldController::class, 'index'])->name('custom-field');
    Route::post('/custom-field', [CustomFieldController::class, 'store'])->name('custom-field.store');

    // Tambahkan rute untuk edit dan update CustomField
    Route::get('/custom-field/edit/{id}', [CustomFieldController::class, 'edit'])->name('custom-field.edit');
    Route::put('/custom-field/update/{id}', [CustomFieldController::class, 'update'])->name('custom-field.update');
    Route::delete('/custom-field/{id}', [CustomFieldController::class, 'destroy'])->name('custom-field.destroy');


    Route::get('/entry-data', [EntryController::class, 'create'])->name('entry-data');
    Route::post('/entry-data', [EntryController::class, 'store'])->name('entry-data.store');
    Route::get('/entry-data/edit/{id}', [EntryController::class, 'edit'])->name('entry-data.edit');
    Route::put('/entry-data/{id}', [EntryController::class, 'update'])->name('entry-data.update');
    Route::delete('/entry-data/{id}', [EntryController::class, 'destroy'])->name('entry-data.destroy');




    Route::get('/doc-approval', [DocApprovalController::class, 'index'])->name('doc-approval');
    Route::post('/doc-approval', [DocApprovalController::class, 'store'])->name('doc-approval.store');
    // Tambahkan rute untuk edit dan update CustomField
    Route::get('/doc-approval/edit/{id}', [DocApprovalController::class, 'edit'])->name('doc-approval.edit');
    Route::put('/doc-approval/update/{id}', [DocApprovalController::class, 'update'])->name('doc-approval.update');
    Route::delete('/doc-approval/{id}', [DocApprovalController::class, 'destroy'])->name('doc-approval.destroy');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
