<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Storage;
use App\Seller;
use App\User;
use App\Product;
use App\Http\Controllers\ApiController;
use App\Http\Requests\SellerProductRequest;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerProductRequest $request,User $seller)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => Product::UNAVAILABLE_PRODUCT,
            'quantity' => $request->quantity,
            'seller_id' => $seller->id,
            'image' => $request->image->store(''),
        ]);

        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SellerProductRequest $request, Seller $seller,Product $product)
    {

        $this->checkSeller($seller,$product);
        $product->fill($request->all());

        if($request->has('status'))
        {
            $product->status = $request->status;
            if($product->isAvailable()&&$product->categories()->count()==0)
                return $this->errorResponse('An active product must have at least one category',409);
        }
        if($request->has('image'))
        {
            Storage::delete($product->image);
            $product->image = $request->image->store('');

        }

        if($product->isClean())
            return $this->errorResponse('you must specify a different value to update',422);

        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller,$product);
        $product->delete();
        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller,Product $product)
    {
        if($seller->id != $product->seller_id)
            abort(422, 'the specified seller is not the actual seller of the product !');

    }
}
