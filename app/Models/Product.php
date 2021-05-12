<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ISBN' ,
        'name' ,
        'image',
        'year_release',
        'description',
        'pages',
        'price',
        'limit_id',
        'publisher_id',
        'author_id'
    ];

    public function genres(){
        return $this->hasMany(ProductGenre::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function logs(){
        return $this->hasMany(ProductLog::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function limit(){
        return $this->belongsTo(Limit::class);
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

}
