<?php

namespace Modules\Notification\Services;

use Modules\Core\Exceptions\ApiException;
use Modules\Notification\Models\NotificationProvider;

class NotificationProviderResolverService
{
    /**
     * @throws ApiException
     */
    public function resolve(string $channel, string $templateKey): array
    {
        $providers = NotificationProvider::query()
            ->where('channel', $channel)
            ->where('is_active', true)
            ->get();

        if ($providers->isEmpty()) {
            throw new ApiException('provider.not_found',['channel'=>$channel],500,'notification');
        }

        // Check for forced provider for the given template
        $forced = $providers->first(function ($provider) use ($templateKey) {
            return is_array($provider->forced_for_templates) &&
                   in_array($templateKey, $provider->forced_for_templates, true);
        });

        if ($forced) {
            return [$forced];
        }

        // Otherwise, return weighted list for distribution
        return $this->weightedShuffle($providers);
    }

    protected function weightedShuffle($providers): array
    {
        $pool = [];

        foreach ($providers as $provider) {
            $weight = max(1, intval($provider->weight)); // Ensure minimum weight of 1
            for ($i = 0; $i < $weight; $i++) {
                $pool[] = $provider;
            }
        }

        shuffle($pool);

        return array_unique($pool, SORT_REGULAR);
    }
}
