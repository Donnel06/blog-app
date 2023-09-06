<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'content'
    ];

    public function user() 
    {
    	return $this->belongsTo(User::class, 'user_id');//un post appartient à un seul utilisateur
    }

    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }
}
