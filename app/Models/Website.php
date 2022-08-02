<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','url'
    ];

    /**
     * Get users who subscribe to the website.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get posts that are published on the website.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
