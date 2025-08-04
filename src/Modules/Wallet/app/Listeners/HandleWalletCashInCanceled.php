<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletCashInCanceledEvent;

class HandleWalletCashInCanceled
{
    /**
     * Create the event listener.
     */
    public function __construct(protected InternalNotificationService $internalNotificationService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(WalletCashInCanceledEvent $event): void
    {
        $user = $event->request->wallet->walletable;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $user,
                template: 'wallet_cash_in_canceled',
                variables: [
                    'amount' => $event->request->amount,
                    'id' => $event->request->id,
                ],
                meta: [
                    'title' => 'واریز ناموفق',
                ]
            )
        );
    }
}
