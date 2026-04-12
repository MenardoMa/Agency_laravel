@extends('admin.back.layout.layout')

@section('title', 'Categorie')

@section('content')
    <h3>Cetegorie</h3>
    <div class="my-3 d-flex align-items-center justify-content-between">
        <p>Liste</p>
        <a href="#" class="btn btn-primary btn-sm" id="btn-show-modal">Create categorie</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">nom</th>
                <th scope="col">slug</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
        </tbody>
    </table>
@endsection