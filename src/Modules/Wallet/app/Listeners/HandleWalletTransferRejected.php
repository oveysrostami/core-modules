<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletTransferRejectedEvent;

class HandleWalletTransferRejected
{
    public function __construct(protected InternalNotificationService $internalNotificationService){}

    public function handle(WalletTransferRejectedEvent $event): void
    {
        $request = $event->request;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->fromWallet->walletable,
                template: 'wallet_transfer_rejected',
                variables: [
                    'amount' => number_format($request->amount),
                    'reason' => $request->reason,
                ],
                meta: [
                    'wallet_transfer_request_id' => $request->id,
                ]
            )
        );
    }
}

