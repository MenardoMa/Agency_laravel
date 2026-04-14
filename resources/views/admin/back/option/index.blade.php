@extends('admin.back.layout.layout')

@section('title', 'Option')

@section('content')
    @include('admin.back.include.modal_option')
    <h3>Options</h3>
    <div class="d-flex align-items-center justify-content-between">
        <p>Liste</p>
        <button class="btn btn-primary btn-sm" id="btn-create-option">Create Option</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Icon</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr id="row_{{ $option->id }}">
                    <th scope="row">{{ $option->id }}</th>
                    <td>{{ $option->name }}</td>
                    <td>{{ $option->icon ?? "Pas d'icon" }}</td>
                    <td class="text-end d-flex align-items-center">
                        <button class="btn btn-secondary btn-sm btn-edit" data-option="{{ $option->id }}">Edit</button>
                        <form action="{{ route("admin.option.destroy", $option->id) }}" method="post" class="ml-2"
                            id="form-delete">
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-delete" data-option="{{ $option->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $options->links() }}
@endsection