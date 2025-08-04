<?php

return [
    'errors' => [
  'wallet.not_match.source_currency_destination_currency' => 'Source Currency not match with destination currency',
  'wallet.balance.not_enough' => 'Balance not enough',
  'wallet.not_found' => 'Wallet not found',
  'gateway.not_found' => 'Payment gateway not found',
  'cash_in_request.not_found' => 'Cash-in request not found',
  'cash_in_request.not_processing' => 'Cash-in request is not in processing state',
  'payment.amount_mismatch' => 'The paid amount does not match the request amount',
  'payment_link.not_found' => 'Payment link not found',
  'payment_link.already_paid' => 'Payment link already processed',
  'payment_link.only_pending_update' => 'Only pending payment links can be updated',
  'payment_link.only_pending_delete' => 'Only pending payment links can be deleted',
  'payment_link.processing' => 'Payment is processing, please try again in :minutes minutes',
],
    'success' => [],
    'warning' => [],
];
