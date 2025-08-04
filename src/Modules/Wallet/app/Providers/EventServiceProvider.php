<?php

namespace Modules\Wallet\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Wallet\Events\CurrencyCreatedEvent;
use Modules\Wallet\Events\WalletCashInApprovedEvent;
use Modules\Wallet\Events\WalletCashInCanceledEvent;
use Modules\Wallet\Events\WalletCashInCreateEvent;
use Modules\Wallet\Events\WalletCashInFailedEvent;
use Modules\Wallet\Events\WalletCashInRejectEvent;
use Modules\Wallet\Events\WalletCashOutApprovedEvent;
use Modules\Wallet\Events\WalletCashOutRequestFailedEvent;
use Modules\Wallet\Events\WalletCashOutRequestRejectEvent;
use Modules\Wallet\Events\WalletPurchaseApprovedEvent;
use Modules\Wallet\Events\WalletPurchaseCreateEvent;
use Modules\Wallet\Events\WalletPurchaseFailedEvent;
use Modules\Wallet\Events\WalletPurchaseRejectedEvent;
use Modules\Wallet\Events\WalletTransferApprovedEvent;
use Modules\Wallet\Events\WalletTransferCreateEvent;
use Modules\Wallet\Events\WalletTransferFailedEvent;
use Modules\Wallet\Events\WalletTransferRejectedEvent;
use Modules\Wallet\Listeners\HandleCurrencyCreated;
use Modules\User\Events\UserCreatedEvent;
use Modules\Wallet\Listeners\HandleUserCreated;
use Modules\Wallet\Listeners\HandleWalletCashInApproved;
use Modules\Wallet\Listeners\HandleWalletCashInCanceled;
use Modules\Wallet\Listeners\HandleWalletCashInFailed;
use Modules\Wallet\Listeners\HandleWalletCashInReject;
use Modules\Wallet\Listeners\HandleWalletCashOutApproved;
use Modules\Wallet\Listeners\HandleWalletCashOutFailed;
use Modules\Wallet\Listeners\HandleWalletCashOutRejected;
use Modules\Wallet\Listeners\HandleWalletPurchaseApproved;
use Modules\Wallet\Listeners\HandleWalletPurchaseCreated;
use Modules\Wallet\Listeners\HandleWalletPurchaseFailed;
use Modules\Wallet\Listeners\HandleWalletPurchaseRejected;
use Modules\Wallet\Listeners\HandleWalletTransferApproved;
use Modules\Wallet\Listeners\HandleWalletTransferCreate;
use Modules\Wallet\Listeners\HandleWalletTransferFailed;
use Modules\Wallet\Listeners\HandleWalletTransferRejected;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        CurrencyCreatedEvent::class => [
            HandleCurrencyCreated::class,
        ],
        UserCreatedEvent::class => [
            HandleUserCreated::class,
        ],
        WalletCashInApprovedEvent::class => [
            HandleWalletCashInApproved::class,
        ],
        WalletCashInCanceledEvent::class => [
            HandleWalletCashInCanceled::class,
        ],
        WalletCashInCreateEvent::class => [

        ],
        WalletCashInFailedEvent::class => [
            HandleWalletCashInFailed::class,
        ],
        WalletCashInRejectEvent::class => [
            HandleWalletCashInReject::class,
        ],
        WalletCashOutApprovedEvent::class => [
            HandleWalletCashOutApproved::class,
        ],
        WalletCashOutRequestFailedEvent::class => [
            HandleWalletCashOutFailed::class
        ],
        WalletCashOutRequestRejectEvent::class => [
            HandleWalletCashOutRejected::class
        ],
        WalletPurchaseApprovedEvent::class => [
            HandleWalletPurchaseApproved::class,
        ],
        WalletPurchaseCreateEvent::class => [
            HandleWalletPurchaseCreated::class,
        ],
        WalletPurchaseFailedEvent::class => [
            HandleWalletPurchaseFailed::class,
        ],
        WalletPurchaseRejectedEvent::class => [
            HandleWalletPurchaseRejected::class,
        ],
        WalletTransferCreateEvent::class => [
            HandleWalletTransferCreate::class,
        ],
        WalletTransferApprovedEvent::class => [
            HandleWalletTransferApproved::class,
        ],
        WalletTransferFailedEvent::class => [
            HandleWalletTransferFailed::class,
        ],
        WalletTransferRejectedEvent::class => [
            HandleWalletTransferRejected::class,
        ]
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
