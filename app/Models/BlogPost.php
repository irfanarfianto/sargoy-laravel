<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'author', 'tags'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });

        static::updating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    // // Konversi tags ke array saat diambil dari database
    // public function getTagsAttribute($value)
    // {
    //     return explode(', ', $value);
    // }

    // // Konversi tags ke string saat disimpan ke database
    // public function setTagsAttribute($value)
    // {
    //     $this->attributes['tags'] = implode(', ', array_unique($value));
    // }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
