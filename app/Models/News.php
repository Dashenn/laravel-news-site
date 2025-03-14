<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = ['title', 'content', 'image', 'user_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'news_user', 'news_id', 'user_id')->withTimestamps();
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'news_likes')->withTimestamps();
    }
}
