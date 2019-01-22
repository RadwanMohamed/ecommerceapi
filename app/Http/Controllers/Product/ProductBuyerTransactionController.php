<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product,User $buyer)
    {
        $rules  = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request,$rules);
        if($buyer->id == $product->seller_id)
        {
            return $this->errorResponse('the buyer must be different from the seller',409);
        }
        if(!$buyer->isVerified())
        {
            return $this->errorResponse('the buyer must be verified user',409);
        }
        if(!$product->seller->isVerified())
        {
            return $this->errorResponse('the seller must be verified user',409);
        }
        
        if(!$product->isAvailable())
        {
            return $this->errorResponse('the product must be  available',409);
        }
        if($product->quantity < $request->quantity)
        {
            return $this->errorResponse('the product does not have enogh units for this transaction',409);
        }
        return DB::Transaction(function() use ($request,$product,$buyer){
            $product->quantity  -= $request->quantity;
            $product->save();
            $transaction = Transaction::create([
                'quantity'      => $request->quantity,
                'buyer_id'      => $buyer->id,
                'product_id'    => $product->id,
            ]);
            return $this->showOne($transaction,201);
        });
    



        
    }

    
}
