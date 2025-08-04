<?php

namespace Modules\Wallet\Enums;

enum WalletPurchaseRequestStatusEnum : string {
    case FAILED = "FAILED";
    case PENDING = "PENDING";
    case SUCCESS = "SUCCESS";
    case REJECTED = "REJECTED";
}
