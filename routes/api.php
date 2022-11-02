<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/*...*/
Route::apiResource('tools', ToolController::class);