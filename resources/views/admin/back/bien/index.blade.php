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
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="table_body">
            <tr id="row_">
                <th></th>
                <td></td>
                <td></td>
                <td class="d-flex align-items-center ml-1">
                    <a href="" class="btn btn-secondary btn-sm btn_edit" data-categorie="">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm btn_delete" data-categorie="">Supprimer</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection