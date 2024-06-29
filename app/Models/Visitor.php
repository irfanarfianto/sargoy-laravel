<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitor_profiles'; 

    protected $fillable = [
        'user_id',
        'no_wa',
        'alamat',
        'birthdate',
        'gender',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
