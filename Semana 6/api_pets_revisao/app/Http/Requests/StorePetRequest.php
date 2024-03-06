<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'age' => 'int',
            'weight' => 'numeric',
            'size' => 'required|string|in:SMALL,MEDIUM,LARGE,EXTRA_LARGE',
            'breed_id' => 'required|int',
            'specie_id' => 'required|int',
            'client_id' => 'int',
            'photo' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do pet é obrigatório',
            'name.max' => 'O nome do pet ultrapssa o limite de 150 caracteres',
            'name.string' => 'O nome deve ser um string',
            'age.int' => 'A idade do pet deve ser um valor inteiro',
            'weight.numeric' => 'O peso do pet deve ser um valor numérico',
            'size.required' => 'O tamanho do pet é obrigatório',
            'size.string' => 'O tamanho do pet deve ser um string',
            'size.in' => 'Os valores permitidos são SMALL,MEDIUM,LARGE,EXTRA_LARGE',
            'breed_id.required' => 'O id da raça é obrigatório',
            'breed_id.int' => 'O id da raça deve ser um valor inteiro',
            'specie_id.required' => 'O id da espécie é obrigatório',
            'specie_id.int' => 'O id da espécie deve ser um valor inteiro',
            'client_id.int' => 'O id do cliente deve ser um valor inteiro',
            'photo.required' => 'A foto do pet é obrigatória'
        ];
    }
}
