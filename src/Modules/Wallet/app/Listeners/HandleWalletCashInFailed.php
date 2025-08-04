<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Wallet\Events\WalletCashInFailedEvent;
use Modules\Notification\Services\InternalNotificationService;

class HandleWalletCashInFailed
{
    public function __construct(protected InternalNotificationService $internalNotificationService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(WalletCashInFailedEvent $event): void
    {
        $user = $event->request->wallet->walletable;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $user,
                template: 'wallet_cash_in_failed',
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
