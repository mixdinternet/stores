<?php

namespace Mixdinternet\Stores\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditStoresRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'required'
            , 'type' => 'required'
            , 'name' => 'required|max:150'
            , 'zipcode' => 'required|max:9'
            , 'address' => 'required'
            , 'city' => 'required'
            , 'state' => 'required'
            , 'description' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}