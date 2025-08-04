<?php

namespace Modules\Wallet\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Modules\Wallet\Models\Currency;
use Modules\Wallet\Classes\DTO\CurrencyDTO;

class CurrencyService
{
    public function all(): Collection
    {
        return Cache::rememberForever('wallet.currencies', fn () => Currency::all());
    }

    public function getByCode(string $code): Currency
    {
        return $this->all()->firstWhere('code', $code);
    }

    public function create(CurrencyDTO $data): Currency
    {
        return Currency::create([
            'name' => $data->name,
            'code' => $data->code,
            'symbol' => $data->symbol,
        ]);
    }

    public function firstOrCreate(CurrencyDTO $data): Currency
    {
        return Currency::updateOrCreate([
            'code' => $data->code,
        ],[
            'symbol' => $data->symbol,'name' => $data->name
        ]);
    }

    public function update(Currency $currency, CurrencyDTO $data): Currency
    {
        $currency->update([
            'name' => $data->name,
            'code' => $data->code,
            'symbol' => $data->symbol,
        ]);

        return $currency;
    }
}
