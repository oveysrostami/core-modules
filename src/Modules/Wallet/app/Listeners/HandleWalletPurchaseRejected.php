<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletPurchaseRejectedEvent;

class HandleWalletPurchaseRejected
{
    public function __construct(protected InternalNotificationService $internalNotificationService)
    {
    }

    public function handle(WalletPurchaseRejectedEvent $event): void
    {
        $request = $event->request;
        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->wallet->walletable,
                template: 'wallet_purchase_rejected',
                variables: [
                    'amount' => number_format($request->amount),
                    'reason' => $request->meta['reason'] ?? null,
                ],
                meta: [
                    'wallet_purchase_request_id' => $request->id,
                    'title' => 'خرید رد شد.',
                ]
            )
        );
    }
}
