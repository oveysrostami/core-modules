<?php

namespace Modules\Wallet\Enums;

enum PaymentLinkStatusEnum: string
{
    case PENDING = 'PENDING';
    case PROCESSING = 'PROCESSING';
    case SUCCESS = 'SUCCESS';
    case FAILED = 'FAILED';
    case CANCELED = 'CANCELED';
}
