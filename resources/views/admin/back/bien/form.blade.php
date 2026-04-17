@extends('admin.back.layout.layout')

@section('title', 'Creation d\'un bien')

@section('content')
    <h3>Creation d'un Bien</h3>
    <div class="mt-4">
        <form action="{{ route("admin.bien.store") }}" method="POST" id="form_bien">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="title">Titre</label>
                    <input type="text" name="title" class="form-control" id="title"
                        placeholder="Ex: Appartement moderne à louer">
                </div>
                <div class="form-group col-md-4">
                    <label for="surface">Surface (m²)</label>
                    <input type="number" name="surface" class="form-control" id="surface" placeholder="Ex: 120">
                </div>
                <div class="form-group col-md-4">
                    <label for="prix">Prix</label>
                    <input type="number" name="prix" class="form-control" id="prix" placeholder="Ex: 150000">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description"
                    placeholder="Décrivez le bien (localisation, état, équipements...)"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="nombre_pieces">Nombre de pièces</label>
                    <input type="number" name="nombre_pieces" class="form-control" id="nombre_pieces" placeholder="Ex: 4">
                </div>
                <div class="form-group col-md-3">
                    <label for="nombre_chambres">Chambres</label>
                    <input type="number" name="nombre_chambres" class="form-control" id="nombre_chambres"
                        placeholder="Ex: 3">
                </div>
                <div class="form-group col-md-3">
                    <label for="nombre_salles_bain">Salles de bain</label>
                    <input type="number" name="nombre_salles_bain" class="form-control" id="nombre_salles_bain"
                        placeholder="Ex: 2">
                </div>
                <div class="form-group col-md-3">
                    <label for="etage">Étage</label>
                    <input type="number" name="etage" class="form-control" id="etage" placeholder="Ex: 2">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" class="form-control" id="adresse"
                        placeholder="Ex: 123 Avenue de la Paix">
                </div>
                <div class="form-group col-md-4">
                    <label for="ville">Ville</label>
                    <input type="text" name="ville" class="form-control" id="ville" placeholder="Ex: Kinshasa">
                </div>
                <div class="form-group col-md-4">
                    <label for="code_postal">Code postal</label>
                    <input type="text" name="code_postal" class="form-control" id="code_postal" placeholder="Ex: 1000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="category_id">Catégorie</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option selected disabled>Choisir une catégorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="statut">Statut</label>
                    <select id="statut" name="statut" class="form-control">
                        @if ($bien->id)
                            @foreach ($statues as $statue)
                                <option value="{{ $statue->value }}">
                                    {{ $statue->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $defaultStatus->value }}" selected>
                                {{ $defaultStatus->name }}
                            </option>
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control">
                        <option selected disabled>Choisir un type d'opération</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->value }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="options" class="font-weight-bold">Options</label>

                    <select id="options" name="options[]" class="form-control" multiple
                        placeholder="Choisir des options...">
                        @foreach ($options as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    </select>

                    <small class="form-text text-muted">
                        Vous pouvez sélectionner plusieurs options.
                    </small>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="hidden" name="is_featured" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured">
                    <label class="form-check-label" for="is_featured">
                        Mettre en avant (Featured)
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm" id="btn_save">
                Créer le bien
            </button>
        </form>
    </div>
@endsection