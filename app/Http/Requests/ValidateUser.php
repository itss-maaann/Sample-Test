<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //I have set this to true so that anyone can perform request just for testing purpose
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|min:11|unique:users,phone,NULL,id,deleted_at,NULL', //if user is soft deleted, then uniqueness will not be applied
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL', //if user is soft deleted, then uniqueness will not be applied
            'photo' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kindly write your Name!',
            'phone.required' => 'Please provide phone number!',
            'phone.min' => 'The phone must be at least 11 characters!',
            'phone.unique' => 'This number already exists, Please provide another phone number!',
            'email.required' => 'Kindly provide Email!',
            'email.email' => 'The mentioned email is not a valid email address!',
            'email.unique' => 'This email already exists, Please provide another email address!',
            'photo.required' => 'Image is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
