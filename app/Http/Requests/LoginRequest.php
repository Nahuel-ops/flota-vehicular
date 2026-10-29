<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool { return true; } // Cambiar a true

    public function rules(): bool|array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }
}


//<?php

//namespace App\Http\Requests;

//use Illuminate\Contracts\Validation\ValidationRule;
//use Illuminate\Foundation\Http\FormRequest;

//lass LoginRequest extends FormRequest
//{
    /**
     * Determine if the user is authorized to make this request.
     */
   // public function authorize(): bool
   // {
   //     return false;
   // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   // public function rules(): array
   // {
    //    return [
            //
   //     ];
   // }
//}
