<?php

namespace Modules\User\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Modules\Notification\Traits\HasNotification;
use Modules\Wallet\Traits\HasBankAccount;
use Modules\Wallet\Traits\HasWallet;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property string $email
 * @property bool $is_banned
 * @property Carbon|null $last_login_at
 * @property Carbon|null $deleted_at
 */
class User extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes, HasNotification, HasWallet, HasBankAccount;

    protected ?string $guard_name = 'api';

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'password',
        'is_banned',
    ];

    protected static function booted(): void
    {
        static::retrieved(function ($user) {
            $user->guard_name = self::resolveGuardName();
        });
        static::creating(function ($user) {
            $user->guard_name = self::resolveGuardName();
        });
    }

    protected static function resolveGuardName(): string
    {
        if (app()->runningInConsole()) {
            return 'api';
        }
        if (request()->is('horizon*')) {
            return 'web';
        }
        if (request()->is('login*')) {
            return 'web';
        }
        return 'api';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_banned' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function findForPassport(string $username): User
    {
        return $this->where('email', $username)
            ->orWhere('mobile_number', $username)
            ->first();
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function routeNotificationFor($driver)
    {
        switch ($driver) {
            case 'sms':
            default:
                return $this->mobile_number;
        }
    }
}
