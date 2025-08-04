<?php
namespace Modules\Notification\Services\Providers\Sms;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\Notification\Exceptions\NotificationDispatchException;
use Modules\Notification\Interfaces\SmsProviderServiceInterface;

class KavehnegarService implements SmsProviderServiceInterface
{
    protected string $apiKey;

    public function configure(string|array $config): static
    {
        if (is_array($config)) {
            $this->apiKey = $config['api_key'] ?? '';
        } else {
            $this->apiKey = $config;
        }
        return $this;
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function sendSingle(string $mobile, string $message, ?int $date = null): array
    {
        $query = [
            'receptor' => $mobile,
            'message' => $message,
        ];

        if ($date) $query['date'] = $date;

        $response = Http::get("https://api.kavenegar.com/v1/{$this->apiKey}/sms/send.json", $query);

        if ($response->failed()) {
            throw new NotificationDispatchException('Kavenegar send failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function sendGroup(array $mobiles, array $messages, array $senders = [], ?int $date = null): array
    {
        if (count($mobiles) > 200) {
            throw new NotificationDispatchException('Receptor limit exceeded (max 200).');
        }

        $payload = [
            'receptor' => $mobiles,
            'message' => $messages,
        ];

        if (!empty($senders)) $payload['sender'] = $senders;
        if ($date) $payload['date'] = $date;

        $response = Http::asForm()->post("https://api.kavenegar.com/v1/{$this->apiKey}/sms/sendarray.json", $payload);

        if ($response->failed()) {
            throw new NotificationDispatchException('Kavenegar sendArray failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function sendPattern(string $mobile, string $templateId, array $parameters): array
    {
        $query = [
            'receptor' => $mobile,
            'template' => $templateId,
            'token' => $parameters[0] ?? '',
        ];

        foreach (array_slice($parameters, 1) as $i => $value) {
            $query['token' . ($i + 2)] = $value;
        }

        $response = Http::get("https://api.kavenegar.com/v1/{$this->apiKey}/verify/lookup.json", $query);

        if ($response->failed()) {
            throw new NotificationDispatchException('Kavenegar OTP failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function checkStatus(array $messageIds): array
    {
        if (count($messageIds) > 500) {
            throw new NotificationDispatchException('Too many message IDs. Max 500 allowed.');
        }

        $response = Http::get("https://api.kavenegar.com/v1/{$this->apiKey}/sms/status.json", [
            'messageid' => implode(',', $messageIds),
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('Kavenegar status check failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function checkDelivery(array $messageIds): array
    {
        if (count($messageIds) > 500) {
            throw new NotificationDispatchException('Too many message IDs. Max 500 allowed.');
        }

        $response = Http::get("https://api.kavenegar.com/v1/{$this->apiKey}/sms/delivery.json", [
            'messageid' => implode(',', $messageIds),
        ]);

        if ($response->failed()) {
            throw new NotificationDispatchException('Kavenegar delivery check failed: ' . $response->body());
        }

        return $response->json();
    }
}
