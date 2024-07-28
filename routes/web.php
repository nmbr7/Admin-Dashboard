<?php

use Illuminate\Support\Facades\Route;

Route::any('/{any}', [App\Http\Controllers\AngularController::class, 'show'])->where('any', '^(?!api).*$');
