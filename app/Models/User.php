<?php

namespace App\Models;

use FontLib\Table\Type\name;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Paddle\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Paddle\Subscription;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'x_oauth_token',
        'x_oauth_token_secret',
        'social_token',
        'login_type',
        'trial_ends_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'x_oauth_token',
        'x_oauth_token_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at' => 'date',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function trialExpired(): bool
    {
        // Check if the trial_ends_at date is not null and has passed
        return $this->trial_ends_at && $this->trial_ends_at->isPast();
    }

//    public function customer(): \Illuminate\Database\Eloquent\Relations\HasOne
//    {
//        return $this->hasOne(Customer::class);
//    }

    /**
     * Get the customer's name to associate with Paddle.
     */
    public function paddleName(): string|null
    {
        return $this->name;
    }

    /**
     * Get the customer's email address to associate with Paddle.
     */
    public function paddleEmail(): string|null
    {
        return $this->email;
    }


}
