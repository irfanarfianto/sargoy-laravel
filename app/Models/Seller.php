<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'seller_profiles'; 

    protected $fillable = [
        'user_id',
        'no_wa',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
