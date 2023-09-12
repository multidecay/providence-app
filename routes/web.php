<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MaidController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(DeviceController::class)->group(function () {
    Route::post('/device/add','device_register');
    Route::post('/device/task','device_task');
    Route::post('/device/report','device_report');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard/tasks', function(){
        return view('pages.dashboard.tasks-reports');
    });

    Route::get('/dashboard/maids', [MaidController::class,'index']);
    Route::get('/dashboard/maids/new', function(){
        return view('pages.dashboard.maid-new');
    });

    Route::post('/dashboard/maids', [MaidController::class,'store']);
    Route::get('/dashboard/maid/{id}', [MaidController::class,'show'])
        ->name('maid.show');

    Route::get('/dashboard/devices',[DeviceController::class,'devices']);
    Route::get('/dashboard/device/{id}',[DeviceController::class,'device']);
    Route::get('/dashboard/device/{id}/tasks',[TaskController::class,'index']);
    Route::get('/dashboard/device/{id}/new-task',[TaskController::class,'create']);
    Route::post('/dashboard/device/{id}/task',[TaskController::class,'store']);
    Route::get('/dashboard/task/{id}',[TaskController::class,'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
