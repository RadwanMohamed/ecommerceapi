<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @const available if products number >0
     */
    const AVAILABLE_PRODUCT = 'available';
    /**
     * @const available if products number >0
     */
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = ['name','description','quantity','status','image','seller_id'];

    /**
     * check whether the product is availanle or not
     * @return boolean 
     */
    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }
    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
