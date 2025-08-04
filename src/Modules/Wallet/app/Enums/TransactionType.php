<?php

namespace Modules\Wallet\Enums;

enum TransactionType: string
{
    case CASH_IN = 'cash_in';
    case CASH_OUT = 'cash_out';
}
