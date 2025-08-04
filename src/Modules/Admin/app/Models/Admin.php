<?php

namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Contracts\OAuthenticatable;
use Modules\Notification\Traits\HasNotification;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

/**
 * @property string $first_name
 * @property string $last_name
 * @property bool $is_banned
 * @property Carbon|null $last_login_at
 * @property Carbon|null $deleted_at
 */
class Admin extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes,HasNotification;

    protected ?string $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'password',
        'is_banned',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::retrieved(function ($user) {
            $user->guard_name = self::resolveGuardName();
        });
        static::creating(function ($user) {
            $user->guard_name = self::resolveGuardName();
        });
    }

    /**
     * Resolve the guard name for the user.
     *
     * @return string
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_banned' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function findForPassport(string $username): Admin
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
                break;

        }
    }
}
