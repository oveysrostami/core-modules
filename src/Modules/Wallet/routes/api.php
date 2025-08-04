<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\V1\Admin\CashInRequestControllerAdmin;
use Modules\Wallet\Http\Controllers\V1\Admin\CashOutRequestControllerAdmin;
use Modules\Wallet\Http\Controllers\V1\Admin\PaymentLinkControllerAdmin;
use Modules\Wallet\Http\Controllers\V1\Admin\PurchaseRequestControllerAdmin;
use Modules\Wallet\Http\Controllers\V1\Admin\TransferRequestControllerAdmin;


Route::prefix('admin/v1/wallet/cash-in-requests')
    ->middleware(['auth:api', 'scope:admin'])
    ->name('admin.v1.wallet.cash-in-requests.')
    ->group(function () {
        Route::get('/', [CashInRequestControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.wallet-cash-in-request.index');

        Route::patch('{cashInRequest}/approve', [CashInRequestControllerAdmin::class, 'approve'])
            ->name('approve')
            ->middleware('permission:admin.v1.wallet-cash-in-request.approve');

        Route::patch('{cashInRequest}/failed', [CashInRequestControllerAdmin::class, 'failed'])
            ->name('failed')
            ->middleware('permission:admin.v1.wallet-cash-in-request.failed');

        Route::patch('{cashInRequest}/reject', [CashInRequestControllerAdmin::class, 'reject'])
            ->name('reject')
            ->middleware('permission:admin.v1.wallet-cash-in-request.reject');

        Route::patch('{cashInRequest}/cancel', [CashInRequestControllerAdmin::class, 'cancel'])
            ->name('cancel')
            ->middleware('permission:admin.v1.wallet-cash-in-request.cancel');
    });

Route::prefix('admin/v1/wallet/cash-out-requests')
    ->middleware(['auth:api', 'scope:admin'])
    ->name('admin.v1.wallet.cash-out-requests.')
    ->group(function () {
        Route::get('/', [CashOutRequestControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.wallet-cash-out-request.index');

        Route::patch('{cashOutRequest}/approve', [CashOutRequestControllerAdmin::class, 'approve'])
            ->name('approve')
            ->middleware('permission:admin.v1.wallet-cash-out-request.approve');

        Route::patch('{cashOutRequest}/failed', [CashOutRequestControllerAdmin::class, 'failed'])
            ->name('failed')
            ->middleware('permission:admin.v1.wallet-cash-out-request.failed');

        Route::patch('{cashOutRequest}/reject', [CashOutRequestControllerAdmin::class, 'reject'])
            ->name('reject')
            ->middleware('permission:admin.v1.wallet-cash-out-request.reject');
    });

Route::prefix('admin/v1/wallet/purchase-requests')
    ->middleware(['auth:api', 'scope:admin'])
    ->name('admin.v1.wallet.purchase-requests.')
    ->group(function () {
        Route::get('/', [PurchaseRequestControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.wallet-purchase-request.index');

        Route::patch('{purchaseRequest}/approve', [PurchaseRequestControllerAdmin::class, 'approve'])
            ->name('approve')
            ->middleware('permission:admin.v1.wallet-purchase-request.approve');

        Route::patch('{purchaseRequest}/failed', [PurchaseRequestControllerAdmin::class, 'failed'])
            ->name('failed')
            ->middleware('permission:admin.v1.wallet-purchase-request.failed');

        Route::patch('{purchaseRequest}/reject', [PurchaseRequestControllerAdmin::class, 'reject'])
            ->name('reject')
            ->middleware('permission:admin.v1.wallet-purchase-request.reject');
    });

Route::prefix('admin/v1/wallet/transfer-requests')
    ->middleware(['auth:api', 'scope:admin'])
    ->name('admin.v1.wallet.transfer-requests.')
    ->group(function () {
        Route::get('/', [TransferRequestControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.wallet-transfer-request.index');

        Route::patch('{transferRequest}/approve', [TransferRequestControllerAdmin::class, 'approve'])
            ->name('approve')
            ->middleware('permission:admin.v1.wallet-transfer-request.approve');

        Route::patch('{transferRequest}/failed', [TransferRequestControllerAdmin::class, 'failed'])
            ->name('failed')
            ->middleware('permission:admin.v1.wallet-transfer-request.failed');

        Route::patch('{transferRequest}/reject', [TransferRequestControllerAdmin::class, 'reject'])
            ->name('reject')
            ->middleware('permission:admin.v1.wallet-transfer-request.reject');
    });


Route::prefix('admin/v1/wallet/payment-links')->name('admin.v1.wallet.payment-link.')
    ->middleware(['auth:api','scope:admin'])->group(function () {
        Route::get('/', [PaymentLinkControllerAdmin::class, 'index'])->name('index')
            ->middleware('permission:admin.v1.wallet.payment-link.index');
        Route::post('/', [PaymentLinkControllerAdmin::class, 'store'])->name('store')
            ->middleware('permission:admin.v1.wallet.payment-link.store');
        Route::get('{paymentLink}', [PaymentLinkControllerAdmin::class, 'show'])->name('show')
            ->middleware('permission:admin.v1.wallet.payment-link.show');
        Route::put('{paymentLink}', [PaymentLinkControllerAdmin::class, 'update'])->name('update')
            ->middleware('permission:admin.v1.wallet.payment-link.update');
        Route::delete('{paymentLink}', [PaymentLinkControllerAdmin::class, 'destroy'])->name('destroy')
            ->middleware('permission:admin.v1.wallet.payment-link.destroy');
    });
