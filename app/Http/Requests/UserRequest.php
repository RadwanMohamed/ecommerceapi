<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\User;

class UserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        switch ($this->method()) {
            case 'POST':{
                return [
                    'name'     => 'required',
                    'email'    => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH':{
                return [
                    'email'    => 'email|unique:users,email'.$request['id'],
                    'password' => 'min:6|confirmed',
                    'admin'    => 'in:'.User::ADMIN_USER.','.USER::REGULAR_USER,
                ];
               
            }
            
            default:break;
        }
        
    }
}
