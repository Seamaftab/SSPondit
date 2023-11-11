@extends('admin.layout.master')

@section('title', 'Show Category')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Category Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Title:</h5>
                                <p>{{ $category->name }}</p>
                                <h5 class="font-weight-bold">Description:</h5>
                                <p>{{ $category->description }}</p>
                            </div>
                        </div>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary mt-4">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
