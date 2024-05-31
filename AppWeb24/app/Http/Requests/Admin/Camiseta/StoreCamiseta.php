<?php

namespace App\Http\Requests\Admin\Camiseta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCamiseta extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.camiseta.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'Nombre' => ['required', 'string', 'max:50'],
            'Descripción' => ['required', 'string', 'max:255'],
            'Precio' => ['required', 'numeric'],
            'Talle' => ['required', 'string', 'in:S,M,L,XL,XXL,XXXL'], //verifica que coincida con estos valores
            'Cantidad' => ['required', 'integer'],
            'Categoría' => ['required', 'string', 'in: Clubes Nacionales, Clubes Internacionales, Selecciones'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
