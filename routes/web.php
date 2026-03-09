<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Developer\ProjectController as DeveloperProjectController;
use App\Http\Controllers\Developer\ProjectUpdateController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () {

    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isDeveloper()) {
            return redirect()->route('developer.dashboard');
        }
        if ($user->isClient()) {
            return redirect()->route('client.dashboard');
        }
    }
    return redirect()->route('login');
})->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/developers/list', [UserController::class, 'developers']);
        Route::get('/clients/list', [UserController::class,'clients']);

        // Clients
        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/data', [ClientController::class, 'data'])->name('clients.data');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

        // Projects
        Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/data', [AdminProjectController::class, 'data'])->name('projects.data');
        Route::post('/projects', [AdminProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{id}/edit', [AdminProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{id}', [AdminProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{id}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');

        
    });

    // Developer
    Route::prefix('developer')->name('developer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('developer.dashboard.index');
        })->name('dashboard');

        Route::get('/projects', [DeveloperProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/data', [DeveloperProjectController::class,'data']);
        Route::get('/projects/{id}', [DeveloperProjectController::class, 'show'])->name('projects.show');

        Route::post('/project-updates', [ProjectUpdateController::class, 'store'])->name('project-updates.store');
        Route::put('/project-updates/{id}', [ProjectUpdateController::class, 'update'])->name('project-updates.update');
        Route::delete('/project-updates/{id}', [ProjectUpdateController::class, 'destroy'])->name('project-updates.destroy');

        Route::post('/attachments/upload', [AttachmentController::class, 'upload'])->name('attachments.upload');
        Route::delete('/attachments/{id}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
    });

    // Clients
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard.index');
        })->name('dashboard');
        Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/data', [ClientProjectController::class,'data']);
        Route::get('/projects/{id}', [ClientProjectController::class, 'show'])->name('projects.show');
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
