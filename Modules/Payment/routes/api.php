<?php

use Modules\Payment\Http\Controllers\Api\PaymentController;

Route::prefix('payments')->name('payments.')->group(function () {

    Route::post('/{order}/pay', [PaymentController::class, 'initiate'])->name('pay');
    Route::post('/{token}/callback', [PaymentController::class, 'callback'])->name('callback');

});
