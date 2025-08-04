<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;

class HandleWalletCashOutApproved
{
    /**
     * Create the event listener.
     */
    public function __construct(protected InternalNotificationService $internalNotificationService){}

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $request = $event->request;
        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->wallet->walletable,
                template: 'wallet_cash_out_approved',
                variables: [
                    'amount' => number_format($request->amount),
                ],
                meta: [
                    'wallet_cash_out_request_id' => $request->id,
                ]
            )
        );
    }
}
