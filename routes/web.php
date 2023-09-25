<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MaidController;
use App\Http\Controllers\ReportedFile;
use App\Http\Controllers\ReportedFileController;
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

Route::get('/dashboard', [DeviceController::class,'devices'])->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(DeviceController::class)->group(function () {
    Route::post('/device/add','device_register');
    Route::post('/device/task','device_task');
    Route::post('/device/report','device_report');
});


Route::middleware('auth')->group(function () {
    // Maids routes
    Route::get('/dashboard/maids', [MaidController::class,'index']);
    Route::post('/dashboard/maids', [MaidController::class,'store']);
    Route::get('/dashboard/maids/new', function(){
        return view('pages.dashboard.maid-new');
    });
    Route::get('/dashboard/maid/{id}', [MaidController::class,'show'])
        ->name('maid.show');
    Route::post('/dashboard/maid/{id}/delete', [MaidController::class,'destroy']);
    Route::post('/dashboard/maids/update', [MaidController::class,'update']);


    // devices routes
    Route::get('/dashboard/devices',[DeviceController::class,'devices']);
    Route::get('/dashboard/device/{id}',[DeviceController::class,'device']);
    Route::post('/dashboard/device/{id}/delete',[DeviceController::class,'delete']);
    Route::get('/dashboard/device/{id}/tasks',[TaskController::class,'index']);
    Route::get('/dashboard/device/{id}/new-task',[TaskController::class,'create']);
    Route::post('/dashboard/device/{id}/task',[TaskController::class,'store']);

    // task routes
    Route::get('/dashboard/task/{id}',[TaskController::class,'show']);
    Route::post('/dashboard/task/{id}/delete',[TaskController::class,'destroy']);

    // file routes
    Route::get('/dashboard/report-file/{id}/download', [ReportedFileController::class,'download']);
    Route::get('/dashboard/report-file/{id}', [ReportedFileController::class,'metadata']);
});

require __DIR__.'/auth.php';
