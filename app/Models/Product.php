<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'thumb',
        'active'
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class,'id','menu_id')
            ->withDefault(['name' => '']);//lấy về trường name của bảng menu thông qua trường menu_id của bảng product;
    }
}
