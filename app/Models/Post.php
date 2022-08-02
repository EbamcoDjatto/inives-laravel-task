<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'website_id',
        'notify',
    ];

    /**
     * Get the website that owns the post.
     *
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
