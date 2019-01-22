<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Product;
class SellerProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                    return [
                        'name'         => 'required',
                        'quantity'     => 'required|integer|min:1',
                        'description'  => 'required',
                        'image'        => 'required|image',
                    ];
            case 'PUT':
            case 'PATCH':{
                    return [
                        'quantity'     => 'integer|min:1',
                        'image'        => 'image',
                        'status'        => 'in:'.Product::AVAILABLE_PRODUCT.','.Product::UNAVAILABLE_PRODUCT,
                    ];
                }
            
            default:
        }
        
    }
}
