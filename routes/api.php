<?php

use App\Http\Controllers\PatientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('valid-token')->group(function () {

    Route::post('/centers/{center}/patients', [PatientsController::class, 'store'])->name('centers.patients.store');
    Route::put('/centers/{center}/patients/{id}', [PatientsController::class, 'update'])->name('centers.patients.update');
    Route::get('/centers/{center}/patients/', [PatientsController::class, 'getCenterPatients'])->name('centers.patients.indexCenterPatients');
    Route::get('/patients', [PatientsController::class, 'indexPatients'])->name('centers.patients.indexPatients');
});
