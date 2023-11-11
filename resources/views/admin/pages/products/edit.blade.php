@extends('admin.layout.master')

@section('title', 'Edit Product')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Edit Product</h3>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">List</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-floating mb-3">
                                <input class="form-control" id="serial" type="text" name="serial" placeholder="Product Serial no." value="{{ old('serial', $product->serial) }}" />
                                <label for="serial">Serial No.</label>
                                @error('serial')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="title" type="text" name="title" placeholder="Product title" value="{{ old('title', $product->title) }}" />
                                <label for="title">Title</label>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="price" type="text" name="price" placeholder="Product Price" value="{{ old('price', $product->price) }}" />
                                <label for="price">Price</label>
                                @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="genre" name="genre">
                                    @foreach($genre as $category)
                                    <option value="{{$category->id}}" {{ $category->id === $product->category ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <label for="genre">Category</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="img" type="file" name="image" placeholder="Product Image" />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="description" type="text" name="description" placeholder="Product Description" value="{{ old('description', $product->description) }}" />
                                <label for="description">Description</label>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="form-check-label">Color : </label>

                            @foreach($colors as $colorID => $colorName)
                                <div class="form-check mb-3">
                                    <input  class="form-check-input" 
                                        id="{{$colorID}}" 
                                        type="checkbox" 
                                        name="color_ID[]" 
                                        value="{{$colorID}}" 
                                        @if(in_array($colorID, old('color_ID', $selectedColors)))
                                            checked
                                        @endif
                                        />
                                    <label class="form-check-label" for="{{$colorID}}">{{$colorName}}</label>
                                </div>
                            @endforeach


                            <div class="form-check mb-3">
                                <input class="form-check-input" id="chk" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="chk">Is Active</label>
                                @error('is_active')
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
