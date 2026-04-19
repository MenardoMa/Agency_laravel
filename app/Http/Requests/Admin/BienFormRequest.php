<?php

namespace App\Http\Requests\Admin;

use App\Enums\BienStatus;
use App\Enums\BienType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BienFormRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'string'],
            'slug' => ['nullable', 'string', 'min:3', Rule::unique('biens', 'slug')->ignore($this->id)],
            'surface' => ['required', 'numeric'],
            'prix' => ['required', 'numeric'],

            'description' => ['required', 'string', 'min:8'],
            'nombre_pieces' => ['required', 'integer', 'min:1'],
            'nombre_chambres' => ['required', 'integer'],
            'nombre_salles_bain' => ['required', 'integer'],
            'etage' => ['nullable', 'integer'],

            'adresse' => ['required', 'string', 'min:3'],
            'ville' => ['required', 'string', 'min:3'],

            'code_postal' => ['required', 'string', 'min:4', 'max:8'],
            'category_id' => ['required', 'exists:categories,id'],

            'statut' => ['required', Rule::enum(BienStatus::class)],
            'type' => ['required', Rule::enum(BienType::class)],
            'options' => ['nullable', 'exists:options,id'],
            'images' => ['array', 'min:1'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ? $this->slug : Str::slug($this->title) . '-' . Str::uuid()
        ]);
    }

    /**
     * 
     * Message de retour
     * 
     * @return array{adresse.min: string, adresse.required: string, adresse.string: string, category_id.exists: string, category_id.required: string, code_postal.max: string, code_postal.min: string, code_postal.required: string, code_postal.string: string, description.min: string, description.required: string, description.string: string, etage.integer: string, nombre_chambres.integer: string, nombre_chambres.required: string, nombre_pieces.integer: string, nombre_pieces.required: string, nombre_salles_bain.integer: string, nombre_salles_bain.required: string, prix.numeric: string, prix.required: string, slug.min: string, slug.string: string, slug.unique: string, status.enum: string, status.required: string, surface.numeric: string, surface.required: string, title.min: string, title.required: string, title.string: string, type.enum: string, type.required: string, ville.min: string, ville.required: string, ville.string: string}
     */
    public function messages(): array
    {
        return [
            // TITLE
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 3 caractères.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',

            // SLUG
            'slug.min' => 'Le slug doit contenir au moins 3 caractères.',
            'slug.string' => 'Le slug doit être une chaîne valide.',
            'slug.unique' => 'Ce slug est déjà utilisé.',

            // SURFACE
            'surface.required' => 'La surface est obligatoire.',
            'surface.numeric' => 'La surface doit être un nombre valide.',

            // PRIX
            'prix.required' => 'Le prix est obligatoire.',
            'prix.numeric' => 'Le prix doit être un nombre valide.',

            // DESCRIPTION
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 8 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',

            // NOMBRES
            'nombre_pieces.required' => 'Le nombre de pièces est obligatoire.',
            'nombre_pieces.integer' => 'Le nombre de pièces doit être un nombre entier.',
            'nombre_pieces.min' => 'Le nombre de pièces doit être au moins égal à 1.',

            'nombre_chambres.required' => 'Le nombre de chambres est obligatoire.',
            'nombre_chambres.integer' => 'Le nombre de chambres doit être un nombre entier.',

            'nombre_salles_bain.required' => 'Le nombre de salles de bain est obligatoire.',
            'nombre_salles_bain.integer' => 'Le nombre de salles de bain doit être un nombre entier.',

            // ETAGE
            'etage.integer' => 'L’étage doit être un nombre entier.',

            // ADRESSE
            'adresse.required' => 'L’adresse est obligatoire.',
            'adresse.min' => 'L’adresse doit contenir au moins 3 caractères.',
            'adresse.string' => 'L’adresse doit être une chaîne de caractères.',

            // VILLE
            'ville.required' => 'La ville est obligatoire.',
            'ville.min' => 'La ville doit contenir au moins 3 caractères.',
            'ville.string' => 'La ville doit être une chaîne de caractères.',

            // CODE POSTAL
            'code_postal.required' => 'Le code postal est obligatoire.',
            'code_postal.min' => 'Le code postal doit contenir au moins 4 caractères.',
            'code_postal.max' => 'Le code postal ne doit pas dépasser 8 caractères.',
            'code_postal.string' => 'Le code postal doit être une chaîne valide.',

            // CATEGORY
            'category_id.required' => 'Veuillez sélectionner une catégorie.',
            'category_id.exists' => 'La catégorie sélectionnée est invalide.',

            // STATUT
            'statut.required' => 'Veuillez sélectionner un statut.',
            'statut.enum' => 'Le statut sélectionné est invalide.',

            // TYPE
            'type.required' => 'Veuillez sélectionner un type.',
            'type.enum' => 'Le type sélectionné est invalide.',

            // OPTIONS
            'options.exists' => 'L\'option sélectionnée est invalide.',

            // IMAGES
            'images.array' => "Les images doivent être envoyées sous forme de liste.",
            'images.min' => "Veuillez ajouter au moins une image.",

            'images.*.required' => "Chaque image est obligatoire.",
            'images.*.image' => "Chaque fichier doit être une image valide.",
            'images.*.mimes' => "Les images doivent être au format jpg, jpeg, png ou webp.",
            'images.*.max' => "Chaque image ne doit pas dépasser 2 Mo.",

        ];
    }
}
