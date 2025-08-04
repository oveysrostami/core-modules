<?php

namespace Modules\Wallet\Http\Controllers\V1\Public;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\UserBaseController;
use Modules\Wallet\Models\PaymentLink;
use Modules\Wallet\Services\PaymentLinkService;
use Modules\Wallet\Transformers\PaymentLinkResource;

class PaymentLinkController extends UserBaseController
{
    public function __construct(protected PaymentLinkService $service) {}

    public function open(string $token)
    {
        $link = PaymentLink::where('token', $token)->firstOrFail();
        $url = $this->service->open($link);
        return redirect()->away($url);
    }

    public function verify(Request $request, string $token)
    {
        $link = PaymentLink::where('token', $token)->firstOrFail();
        $link = $this->service->verify($link, $request);
        return $this->success(new PaymentLinkResource($link));
    }
}
