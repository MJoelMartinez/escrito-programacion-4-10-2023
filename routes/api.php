<?php

use App\Http\Controllers\TareaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function()
{
    Route::get('/tarea',
        [TareaController::class, 'ListarTodos']
    );

    Route::get('/tarea/{id}',
        [TareaController::class, 'ListarUno']
    );

    Route::post('/tarea',
        [TareaController::class, 'Crear']
    );

    Route::put('/tarea/{id}',
        [TareaController::class, 'Modificar']
    );

    Route::delete('/tarea/{id}',
        [TareaController::class, 'Eliminar']
    );
});
