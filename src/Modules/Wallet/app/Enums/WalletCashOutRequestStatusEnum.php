<?php

namespace Modules\Wallet\Enums;

enum WalletCashOutRequestStatusEnum : string {
    case FAILED = "FAILED";
    case PENDING = "PENDING";
    case SUCCESS = "SUCCESS";
    case REJECTED = "REJECTED";
}

