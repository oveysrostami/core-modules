<?php

namespace Modules\User\Http\Controllers\V1\Auth;

use Exception;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\UserBaseController;
use Modules\User\Http\Requests\UserLoginRequest;
use Modules\User\Transformers\UserResource;

class UserAuthController extends UserBaseController
{
    /**
     * @throws Exception
     */
    public function login(UserLoginRequest $request)
    {
        $formRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('user.passport.client_id'),
            'client_secret' => config('user.passport.client_secret'),
            'username' => $request->username,
            'password' => $request->password,
            'scope' => 'user',
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
        return $this->success([], 'user::message.success.logout');
    }

    public function me(Request $request)
    {
        return $this->success(new UserResource($request->user()));
    }
}
