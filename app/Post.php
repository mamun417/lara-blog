<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 * @method static create(array $all)
 * @method static publishedAndActive()
 */
class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'image', 'body', 'status', 'is_approved'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function favoriteUsers(){
        return $this->belongsToMany(User::class, 'fav_post_user', 'post_id')->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query){
        return $query->where('is_approved', 1);
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopePublishedAndActive($query){
        return $query->published()->active();
        //return $query->where('status', 1)->where('is_approved', 1);
    }
}
