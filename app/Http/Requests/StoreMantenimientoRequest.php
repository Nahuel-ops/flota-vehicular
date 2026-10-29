<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Habilitar la autorización para el formulario
    }

    public function rules(): array
    {
        return [
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'tipo' => 'required|in:Preventivo,Correctivo',
            'fecha' => 'required|date',
            'kilometraje' => 'required|integer|min:0',
            'taller' => 'required|string|max:255',
            'costo_total' => 'required|numeric|min:0',
            'factura_imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de imagen (máx 2MB)
        ];
    }
}
















//<?php

//namespace App\Http\Requests;

//use Illuminate\Contracts\Validation\ValidationRule;
//use Illuminate\Foundation\Http\FormRequest;

//class StoreMantenimientoRequest extends FormRequest
//{
    /**
     * Determine if the user is authorized to make this request.
     */
    //public function authorize(): bool
   // {
   //     return false;
   // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    //public function rules(): array
    //{
      //  return [
            //
       // ];
   // }
//}


