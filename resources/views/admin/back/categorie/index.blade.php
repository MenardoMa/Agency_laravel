@extends('admin.back.layout.layout')

@section('title', 'Categorie')

@section('content')
    @include('admin.back.include.modal')
    <h3>Cetegorie</h3>
    <div class="my-3 d-flex align-items-center justify-content-between">
        <p>Liste</p>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" id="btn_over_modal">
            Create Categorie
        </button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">nom</th>
                <th scope="col">description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="table_body">
            @foreach ($categories as $categorie)
                <tr id="row_{{ $categorie->id }}">
                    <th>{{ $categorie->id }}</th>
                    <td>{{ $categorie->name }}</td>
                    <td>{{ $categorie->description }}</td>
                    <td class="d-flex align-items-center ml-1">
                        <a href="" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('admin.categorie.destroy', $categorie->id) }}" method="POST" class="form_delete">
                            <button type="button" class="btn btn-danger btn-sm btn_delete"
                                data-categorie="{{ $categorie->id }}">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}

@endsection