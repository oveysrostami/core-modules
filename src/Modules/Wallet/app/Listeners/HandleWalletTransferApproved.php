<?php

namespace Modules\Wallet\Listeners;

use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Wallet\Events\WalletTransferApprovedEvent;

class HandleWalletTransferApproved
{
    public function __construct(protected InternalNotificationService $internalNotificationService){}

    public function handle(WalletTransferApprovedEvent $event): void
    {
        $request = $event->request;

        $this->internalNotificationService->create(
            new InternalNotificationDTO(
                user: $request->fromWallet->walletable,
                template: 'wallet_transfer_approved',
                variables: [
                    'amount' => number_format($request->amount),
                    'to_wallet_id' => $request->to_wallet_id,
                ],
                meta: [
                    'wallet_transfer_request_id' => $request->id,
                ]
            )
        );
    }
}

