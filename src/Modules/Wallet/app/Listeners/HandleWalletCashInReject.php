<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletCashInFailedEvent;
use Modules\Wallet\Events\WalletCashInRejectEvent;

class HandleWalletCashInReject
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
    public function handle(WalletCashInRejectEvent $event): void
    {
        $user = $event->request->wallet->walletable;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $user,
                template: 'wallet_cash_in_rejected',
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
