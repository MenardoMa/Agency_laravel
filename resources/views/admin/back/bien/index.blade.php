@extends('admin.back.layout.layout')

@section('title', 'Bien')

@section('content')
    <h3>Les Biens</h3>
    <div class="my-3 d-flex align-items-center justify-content-between">
        <p>Liste</p>
        <a href="{{ route('admin.bien.form_create') }}" class="btn btn-primary btn-sm">
            Create Bien
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">nom</th>
                <th scope="col">description</th>
                <th scope="col">Categorie</th>
                <th scope="col">options</th>
                <th scope="col">is Featured</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="table_body">
            @foreach ($biens as $bien)
                <tr id="row_{{ $bien->id }}">
                    <th>{{ $bien->id }}</th>
                    <td>{{ $bien->title }}</td>
                    <td>{{ $bien->description }}</td>
                    <td>{{ $bien->category->name }}</td>
                    <td>""</td>
                    <td>{{ $bien->is_is_featured ? "Oui" : "Non" }}</td>
                    <td class="d-flex align-items-center ml-1">
                        <a href="" class="btn btn-secondary btn-sm btn_edit" data-option="">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm btn_delete_option"
                            data-option="{{ $bien->id }}">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection