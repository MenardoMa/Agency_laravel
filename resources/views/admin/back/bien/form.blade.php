@extends('admin.back.layout.layout')

@section('title', 'Creation d\'un bien')

@section('content')
    @if ($bien->id)
        <h4>Modifier le Bien</h4>
    @else
        <h4>Creation d'un Bien</h4>
    @endif
    <div class="mt-4">
        <form action="{{ $bien->id ? route("admin.bien.update", $bien) : route("admin.bien.store") }}" method="POST"
            id="form_bien" enctype="multipart/form-data">
            @method($bien->id ? 'PUT' : 'POST')
            <div class="row">
                <!-- COLONNE 8 -->
                <div class="col-md-9">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="title">Titre</label>
                            <input type="text" name="title" value="{{ old('title') ?? $bien->title ?? '' }}"
                                class="form-control" id="title">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="surface">Surface (m²)</label>
                            <input type="number" name="surface" value="{{ old('surface') ?? $bien->surface ?? '' }}"
                                class="form-control" id="surface">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="prix">Prix</label>
                            <input type="number" name="prix" value="{{ old('prix') ?? $bien->prix ?? '' }}"
                                class="form-control" id="prix">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control"
                            id="description">{{ old('description') ?? $bien->description ?? '' }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Nombre de pièces</label>
                            <input type="number" name="nombre_pieces"
                                value="{{ old('nombre_pieces') ?? $bien->nombre_pieces ?? '' }}" class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Chambres</label>
                            <input type="number" name="nombre_chambres"
                                value="{{ old('nombre_chambres') ?? $bien->nombre_chambres ?? '' }}" class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Salles de bain</label>
                            <input type="number" name="nombre_salles_bain"
                                value="{{ old('nombre_salles_bain') ?? $bien->nombre_salles_bain ?? '' }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Étage</label>
                            <input type="number" name="etage" value="{{ old('etage') ?? $bien->etage ?? '' }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Adresse</label>
                            <input type="text" name="adresse" value="{{ old('adresse') ?? $bien->adresse ?? '' }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Ville</label>
                            <input type="text" name="ville" value="{{ old('ville') ?? $bien->ville ?? '' }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Code postal</label>
                            <input type="text" name="code_postal"
                                value="{{ old('code_postal') ?? $bien->code_postal ?? '' }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Catégorie</label>
                            <select name="category_id" class="form-control">
                                <option disabled selected>Choisir une catégorie</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ (old('category_id') ?? $bien->category_id ?? '') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Statut</label>
                            <select name="statut" class="form-control">
                                @if($bien->id)
                                    @foreach ($statues as $statue)
                                        <option value="{{ $statue->value }}" {{ (old('statut') ?? $bien->statut ?? $defaultStatus->value) == $statue->value ? 'selected' : '' }}>
                                            {{ $statue->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ $defaultStatus->value }}" selected>{{ $defaultStatus->name }}</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option disabled {{ old('type', $bien->type ?? '') ? '' : 'selected' }}>
                                    Choisir un type
                                </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->value }}" {{ old('type', $bien->type ?? '') == $type->value ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Options</label>
                            <select name="options[]" class="form-control" multiple>
                                @foreach ($options as $option)
                                    <option value="{{ $option->id }}" {{ in_array($option->id, old('options') ?? ($bien->options->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $option->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ (old('is_featured') ?? $bien->is_featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Mettre en avant
                            </label>
                        </div>
                    </div>
                </div>

                <!-- COLONNE 4 -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="images">Ajouter des images</label>
                        <input type="file" name="images[]" id="images" class="form-control-file" multiple>
                    </div>

                    <div id="preview_images" class="image-grid mt-3">
                        @foreach ($bien->images as $image)
                            <div class="image-item" data-id="{{ $image->id }}">
                                <img src="{{ $image->getImageUrl() }}" id="image">
                                <button type="button" class="btn-delete-image d-flex align-items-center justify-content-center"
                                    data-id="{{ $image->id }}">&times;</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm" id="btn_save">
                @if ($bien->id)
                    Sauvegarde les modifications
                @else
                    Créer le bien
                @endif
            </button>
        </form>
    </div>
@endsection

@section("scripts")
    <script>
        // SELECT MULTIPLE
        new TomSelect("select[multiple]", {
            plugins: ["remove_button"],
            placeholder: "Choisir des options...",
            maxItems: null,
            hideSelected: true,
            closeAfterSelect: false,
        });
    </script>
@endsection