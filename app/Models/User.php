<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illunimate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'github_id',
        'github_token',
        'github_refresh_token',
        'discord_id',
        'discord_token',
        'discord_refresh_token',
        'credit',
        'email_offers',
        'order_updates',
        'currency',
        'language',
        'theme',
        'data_sharing'
    ];
 

    public $timestamps = false;


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'credit' => 'float',
        'email_offers' => 'boolean',
        'order_updates' => 'boolean',
        'data_sharing' => 'boolean'
    ];
    public function basket()
{
    return $this->hasMany(Basket::class);
}

public function orders()
{
    return $this->hasMany(Order::class);
}

}
