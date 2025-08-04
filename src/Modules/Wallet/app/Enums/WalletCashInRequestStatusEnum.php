<?php

namespace Modules\Wallet\Enums;

enum WalletCashInRequestStatusEnum : string {
    case FAILED = "FAILED";
    case PENDING = "PENDING";
    case SUCCESS = "SUCCESS";
    case REJECTED = "REJECTED";
    case PROCESSING = "PROCESSING";
    case CANCELED = "CANCELED";

}
