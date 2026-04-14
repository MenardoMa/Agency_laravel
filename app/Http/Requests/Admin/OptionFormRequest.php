<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OptionFormRequest extends FormRequest
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
            "name" => ['required', 'string', 'min:3'],
            "slug" => ['string', 'min:3', Rule::unique('options', 'slug')->ignore($this->id)]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "slug" => $this->slug ? $this->slug : Str::slug($this->name)
        ]);
    }

    public function messages()
    {
        return [
            "name.required" => "Le nom est obligatoire",
            "name.string" => "Le nom doit être une chaîne de caractères",
            "name.min" => "Le nom doit contenir au moins 3 caractères",

            "slug.required" => "Le slug est obligatoire",
            "slug.string" => "Le slug doit être une chaîne de caractères",
            "slug.min" => "Le slug doit contenir au moins 3 caractères",
            "slug.unique" => "Ce slug est déjà utilisé",
        ];
    }
}
