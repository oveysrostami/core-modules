<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletPurchaseApprovedEvent;

class HandleWalletPurchaseApproved
{
    public function __construct(protected InternalNotificationService $internalNotificationService)
    {
    }

    public function handle(WalletPurchaseApprovedEvent $event): void
    {
        $request = $event->request;
        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->wallet->walletable,
                template: 'wallet_purchase_approved',
                variables: [
                    'amount' => number_format($request->amount),
                ],
                meta: [
                    'wallet_purchase_request_id' => $request->id,
                    'title' => 'خرید شما با موفقیت تایید شد.',
                ]
            )
        );
    }
}
