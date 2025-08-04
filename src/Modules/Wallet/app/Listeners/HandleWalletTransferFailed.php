<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletTransferFailedEvent;

class HandleWalletTransferFailed
{
    public function __construct(protected InternalNotificationService $internalNotificationService){}

    public function handle(WalletTransferFailedEvent $event): void
    {
        $request = $event->request;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->fromWallet->walletable,
                template: 'wallet_transfer_failed',
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

