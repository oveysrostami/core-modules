<?php

namespace Modules\Notification\Services\Providers\Sms;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\Notification\Exceptions\NotificationDispatchException;
use Modules\Notification\Interfaces\SmsProviderServiceInterface;

class FarazSmsService implements SmsProviderServiceInterface
{
    protected string $apiKey;
    protected string $secretKey;
    protected ?string $lineNumber = null;

    /**
     * @throws NotificationDispatchException
     */
    public function configure(array $config): static
    {
        $this->apiKey = $config['api_key'] ?? '';
        $this->secretKey = $config['secret_key'] ?? '';
        $this->lineNumber = $config['line_number'] ?? null;

        if (! $this->apiKey || ! $this->secretKey) {
            throw new NotificationDispatchException('FarazSMS config incomplete');
        }

        return $this;
    }

    /**
     * @param string $mobile
     * @param string $message
     * @param int|null $date
     * @return array
     * @throws ConnectionException
     * @throws NotificationDispatchException
     */
    public function sendSingle(string $mobile, string $message, ?int $date = null): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.sms.ir/v1/send', [
            'Mobile'     => $mobile,
            'Message'    => $message,
            'LineNumber' => $this->lineNumber,
            'APIKey'     => $this->apiKey,
            'SecretKey'  => $this->secretKey,
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('FarazSMS send failed: ' . $response->body());
        }

        return $response->json();
    }
    /**
     * ارسال پیامک با استفاده از الگو (Pattern)
     *
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function sendPattern(string $mobile, string $templateId, array $parameters): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.sms.ir/v1/send/verify', [
            'Mobile'     => $mobile,
            'TemplateId' => $templateId,
            'Parameters' => collect($parameters)
                ->map(fn ($value, $key) => ['Parameter' => $key, 'ParameterValue' => $value])
                ->values()
                ->toArray(),
            'APIKey'     => $this->apiKey,
            'SecretKey'  => $this->secretKey,
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('FarazSMS pattern send failed: ' . $response->body());
        }

        return $response->json();
    }
    /**
     * بررسی وضعیت پیامک‌ها با استفاده از شناسه پیامک (message ID)
     *
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function checkStatus(array $messageIds): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.sms.ir/v1/get-message-status', [
            'APIKey'     => $this->apiKey,
            'SecretKey'  => $this->secretKey,
            'MessageId'  => $messageIds,
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('FarazSMS status check failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * دریافت وضعیت تحویل پیامک‌ها (Delivery Report)
     *
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function checkDelivery(array $messageIds): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.sms.ir/v1/get-delivery', [
            'APIKey'     => $this->apiKey,
            'SecretKey'  => $this->secretKey,
            'MessageId'  => $messageIds,
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('FarazSMS delivery check failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws NotificationDispatchException
     */
    public function sendGroup(array $mobiles, array $messages, array $senders = [], ?int $date = null): array
    {
        throw new NotificationDispatchException('sendGroup is not implemented for FarazSmsService.');
    }
}
