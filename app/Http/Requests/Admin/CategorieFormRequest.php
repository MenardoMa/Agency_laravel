<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategorieFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'description' => ['nullable', 'min:8', 'string'],
            'slug' => ['required', 'min:3', Rule::unique('categories', 'slug')],
        ];
    }

    /**
     * Preparation de slug au cas ou on le
     * 
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ? $this->slug : Str::slug($this->name)
        ]);
    }

    /**
     * Message de retour en cas d'erreur
     * 
     * @return array{description.min: string, nom.min: string, nom.required: string}
     */
    public function messages()
    {
        return [
            "nom.required" => "Le nom est obligatoire",
            "nom.min" => "Le nom doit contenir au moins 3 caractères",
            "description.min" => "La description doit contenir au moins 8 caractères",

            "slug.required" => "Le slug est obligatoire",
            "slug.unique" => "Ce slug existe déjà",
            "slug.min" => "Le slug doit contenir au moins 3 caractères",
        ];
    }
}
