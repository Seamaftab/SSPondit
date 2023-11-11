@extends('admin.layout.master')

@section('title', 'Edit Color')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Edit Color</h3>
                        <a href="{{ route('colors.index') }}" class="btn btn-outline-primary">List</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('colors.update' , $color)}}">
                            @csrf
                            @method('patch')
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" type="text" name="name" placeholder="Color Name" value="{{ old('name' , $color->name)}}"/>
                                <label for="name">Color Name</label>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="hex" type="text" name="hex" placeholder="Hex Color Code" value="{{ old('hex') }}"/>
                                <label for="hex">Hex Color Code</label>
                                @error('hex')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
