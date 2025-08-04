<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Wallet\Events\WalletCashInApprovedEvent;
use Modules\Notification\Services\InternalNotificationService;

class HandleWalletCashInApproved
{
    /**
     * Create the event listener.
     */
    public function __construct(protected InternalNotificationService $internalNotificationService){}

    /**
     * Handle the event.
     */
    public function handle(WalletCashInApprovedEvent $event): void
    {
        $user = $event->request->wallet->walletable;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $user,
                template: 'wallet_cash_in_approved',
                variables: [
                    'amount' => $event->request->amount,
                ],
                meta: [
                    'title' => 'واریز شما با موفقیت تایید شد.',
                ]
            )
        );
    }
}
