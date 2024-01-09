<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

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

Route::middleware(['validarId'])->group(function () {
    
    Route::controller(AlumnoController::class)->group(function () {

        Route::get("delete",        "deleteAlumno")->name("deleteAlumno");
        Route::get("modify",        "modifyAlumno")->name("modifyAlumno");
        Route::get("getAlumno",     "getAlumno")->name("getAlumno");

    });
});

Route::controller(AlumnoController::class)->group(function () {

    Route::get("create",        "createAlumno")->name("createAlumno");
    Route::get("getAlumnos",    "getAlumnos")->name("getAlumnos");

});