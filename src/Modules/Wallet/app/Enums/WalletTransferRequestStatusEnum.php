<?php

namespace Modules\Wallet\Enums;

enum WalletTransferRequestStatusEnum : string {
    case FAILED = "FAILED";
    case PENDING = "PENDING";
    case SUCCESS = "SUCCESS";
    case REJECTED = "REJECTED";
}
