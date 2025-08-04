<?php

namespace Modules\Admin\Http\Controllers\V1\Auth;

use Exception;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\AdminLoginRequest;
use Modules\Admin\Transformers\AdminResource;
use Modules\Core\Http\Controllers\V1\AdminBaseController;

class AdminAuthController extends AdminBaseController
{
    /**
     * @throws Exception
     */
    public function login(AdminLoginRequest $request)
    {
        $formRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('admin.passport.client_id'),
            'client_secret' => config('admin.passport.client_secret'),
            'username' => $request->username,
            'password' => $request->password,
            'scope' => 'admin',
        ]);

        $response = app()->handle($formRequest);

        if ($response->getStatusCode() !== 200) {
            return $this->error('auth.failed', [],400,'core',$response->getContent());
        }

        $tokenData = json_decode($response->getContent(), true);

        return $this->success([
            'token' => $tokenData,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->success([], 'admin::message.success.logout');
    }

    public function me(Request $request)
    {
        return $this->success(new AdminResource($request->user()));
    }
}
