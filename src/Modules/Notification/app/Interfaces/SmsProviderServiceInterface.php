<?php
namespace Modules\Notification\Interfaces;

interface SmsProviderServiceInterface
{
    /**
     * مقداردهی اولیه تنظیمات provider مثل API Key و ...
     */
    public function configure(array $config): static;

    /**
     * ارسال پیامک تکی ساده (متن مستقیم)
     */
    public function sendSingle(string $mobile, string $message, ?int $date = null): array;

    /**
     * ارسال پیامک گروهی ساده (چند شماره، چند متن)
     */
    public function sendGroup(array $mobiles, array $messages, array $senders = [], ?int $date = null): array;

    /**
     * ارسال پیامک الگو (Pattern)
     */
    public function sendPattern(string $mobile, string $templateId, array $parameters): array;

    /**
     * بررسی وضعیت پیام‌ها با Message ID
     */
    public function checkStatus(array $messageIds): array;

    /**
     * بررسی وضعیت تحویل پیام‌ها (Delivery Report)
     */
    public function checkDelivery(array $messageIds): array;
}
