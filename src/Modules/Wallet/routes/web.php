<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\V1\Public\PaymentLinkController;

Route::prefix('payment-links')->name('wallet.payment-link.')->group(function () {
    Route::get('{token}', [PaymentLinkController::class, 'open'])->name('open');
    Route::get('{token}/verify', [PaymentLinkController::class, 'verify'])->name('verify');
});
