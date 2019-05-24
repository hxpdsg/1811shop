<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandPost extends FormRequest
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
        return [
            'brand_name' => 'required|unique:brand|max:255',         
            'brand_url' => 'required',     
            'brand_logo' => 'required',     
            'brand_desc' => 'required',     
        ];
    }

    public function messages(){    
       return [         
                'brand_name.required' => '用户名不能为空!',
                'brand_name.unique' => '用户名已存在!',
                'brand_name.max' => '用户名长度不能超过255!',
                'brand_url.required' => '网址不能为空!',
                'brand_logo.required' => 'logo不能为空!',
                'brand_desc.required' => '描述不能为空!',    
       ]; 
   } 
}
