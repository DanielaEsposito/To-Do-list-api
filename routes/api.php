<?php

use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\TaskController;
use App\Models\Category;
use App\Models\Priorities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/tasks', TaskController::class)->middleware(['auth:sanctum']);
Route::resource('/notes', NoteController::class)->middleware(['auth:sanctum']);
Route::get('tasks-categories', function () {
    return response()->json([
        'success' => true,
        'data' => Category::all()
    ]);
});
Route::get('tasks-priorities', function () {
    return response()->json([
        'success' => true,
        'data' => Priorities::all()
    ]);
});
