<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    //protected $fillable = ['serial','title', 'price', 'image', 'description', 'is_active', 'category'];
    protected $guarded = [];

    public function genre()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity','color');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
