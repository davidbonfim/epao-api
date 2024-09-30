<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpaoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->group(
        function () {
            Route::prefix('auth')->group(
                function () {
                    Route::post('/login', 'login');
                    Route::post('/register', 'register');
                    Route::post('/logout', 'logout');
                }
            );
        }
    );

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::controller(AuthController::class)->group(
            function () {
                Route::prefix('auth')->group(
                    function () {
                        Route::post('/logout', 'logout');
                    }
                );
            }
        );

        Route::controller(EpaoController::class)->group(
            function () {
                Route::prefix('epao')->group(
                    function () {
                        Route::post('/', 'create');
                    }
                );
            }
        );
    });

    Route::controller(CheckoutController::class)->group(
        function () {
            Route::prefix('checkout')->group(
                function () {
                    Route::post('/', 'create');
                }
            );
        }
    );
});



