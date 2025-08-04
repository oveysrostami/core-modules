<?php

namespace Modules\Wallet\Classes;

use chillerlan\SimpleCache\CacheException;
use Psr\SimpleCache\InvalidArgumentException;
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\{Contracts\ReceiptInterface,
    Exceptions\PurchaseFailedException,
    Invoice,
    Receipt,
    RedirectionForm};

class JibitDriver extends Driver
{
    protected JibitClientDriver $jibit;

    /**
     * Invoice
     *
     * @var Invoice
     */
    protected $invoice;

    /**
     * Driver settings
     *
     * @var object
     */
    protected $settings;

    /**
     * Payment URL
     *
     * @var string
     */
    protected $paymentUrl;

    /**
     * @throws CacheException
     */
    public function __construct(Invoice $invoice, $settings)
    {
        $this->invoice($invoice);
        $this->settings = (object) $settings;
        $this->jibit = new JibitClientDriver(
            $this->settings->apiKey,
            $this->settings->apiSecret,
            $this->settings->apiPaymentUrl,
            $this->settings->tokenStoragePath
        );
    }

    /**
     * Purchase invoice
     *
     * @return string
     * @throws PurchaseFailedException
     */
    public function purchase(): string
    {
        $amount = $this->invoice->getAmount() * ($this->settings->currency == 'T' ? 10 : 1); // Convert to Rial

        $requestResult = $this->jibit->paymentRequest(
            $amount,
            $this->invoice->getUuid(),
            $this->invoice->getDetail('mobile'),
            $this->settings->callbackUrl
        );


        if (! empty($requestResult['pspSwitchingUrl'])) {
            $this->paymentUrl = $requestResult['pspSwitchingUrl'];
        }

        if (! empty($requestResult['errors'])) {
            $errMsgs = array_map(fn (array $err) => $err['code'], $requestResult['errors']);

            throw new PurchaseFailedException(implode('\n', $errMsgs));
        }

        $purchaseId = $requestResult['purchaseId'];
        $referenceNumber = $requestResult['clientReferenceNumber'];

        $this->invoice->detail('referenceNumber', $referenceNumber);
        $this->invoice->transactionId($purchaseId);

        return $purchaseId;
    }

    /**
     * Pay invoice
     */
    public function pay() : RedirectionForm
    {
        $url = $this->paymentUrl;

        return $this->redirectWithForm($url, [], 'GET');
    }

    /**
     * Verify payment
     *
     * @throws InvalidPaymentException
     * @throws PurchaseFailedException
     * @throws InvalidArgumentException
     */
    public function verify(): ReceiptInterface
    {
        $purchaseId = $this->invoice->getTransactionId();

        $requestResult = $this->jibit->paymentVerify($purchaseId);

        if (! empty($requestResult['status']) && $requestResult['status'] === 'SUCCESSFUL') {
            $order = $this->jibit->getOrderById($purchaseId);

            $receipt = new Receipt('jibit', $purchaseId);
            return $receipt->detail('payerCard', $order['elements']['payerCardNumber'] ?? '');
        }

        throw new InvalidPaymentException('Payment encountered an issue.');
    }
}
