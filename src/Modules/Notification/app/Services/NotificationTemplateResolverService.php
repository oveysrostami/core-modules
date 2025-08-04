<?php

namespace Modules\Notification\Services;

use Modules\Core\Exceptions\ApiException;
use Modules\Notification\Models\NotificationTemplate;

class NotificationTemplateResolverService
{
    /**
     * @throws ApiException
     */
    public function resolve(string $channel, string $key, array $variables = []): string
    {
        $template = NotificationTemplate::query()
            ->where('channel', $channel)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        if (! $template) {
            throw new ApiException('template.not_found',['key'=>$key,'channel'=>$channel],500,'notification');
        }

        return $this->replaceVariables($template->content, $variables);
    }

    protected function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        return $content;
    }
}
