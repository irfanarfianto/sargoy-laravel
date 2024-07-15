<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->translatedFormat('l, d F Y H:i');
    }

    /**
     * Define a one-to-one relationship with Seller profile.
     */
    public function sellerProfile()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * Define a one-to-one relationship with Admin profile.
     */
    public function adminProfile()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Define a one-to-one relationship with Visitor profile.
     */
    public function visitorProfile()
    {
        return $this->hasOne(Visitor::class);
    }


    /**
     * Define a one-to-many relationship with products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
