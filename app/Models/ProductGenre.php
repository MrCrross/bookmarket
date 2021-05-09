<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id' ,
        'genre_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

}
