<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->name('api.')->group(function () {
    $moduleRoutes = require base_path('routes/module_routes.php');

    Route::prefix('customer')
        ->name("customer.")
        ->middleware(config("modules.middleware.customer", []))
        ->group(fn() => array_map(fn($file) => require $file, $moduleRoutes['customer']));

    Route::name("public.")
//        ->middleware(config("modules.middleware.public", []))
        ->group(fn() => array_map(fn($file) => require $file, $moduleRoutes['public']));
});
