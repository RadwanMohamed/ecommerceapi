<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\SellerScope;
class Seller extends User
{
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
