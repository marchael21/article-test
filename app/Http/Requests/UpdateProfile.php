<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;

class UpdateProfile extends FormRequest
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

        $user = User::find(Auth::id());
        
        if(isset($this->password) && !empty($this->password)) 
        {

            return [
                'name'              => 'required|string|max:255',
                'username'          => 'required|string|max:255|unique:users,username,'.$user->id,
                'email'             => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'contact_number'    => 'max:50',
                'current_password'  => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        return $fail(__('The current password doesn\'t match'));
                    }
                }],
                'password'          => 'required|string|min:8|confirmed',
            ];
        }
        else
        {
            return [
                'name'              => 'required|string|max:255',
                'username'          => 'required|string|max:255|unique:users,username,'.$user->id,
                'email'             => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'contact_number'    => 'max:50',
            ];            
        }
    }
}
