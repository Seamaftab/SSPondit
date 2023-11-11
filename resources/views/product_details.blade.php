<x-frontend.master>
    <x-slot name="title">SiS | Product Details</x-slot>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Product Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Category:</h5>
                                    <p>{{ $product->genre->name }}</p>
                                    <h5 class="font-weight-bold">Title:</h5>
                                    <p>{{ $product->title }}</p>
                                    <h5 class="font-weight-bold">Price:</h5>
                                    <p>{{ $product->price }}</p>
                                    <h5 class="font-weight-bold">Description:</h5>
                                    <p>{{ $product->description }}</p>
                                    <h5 class="font-weight-bold">Status:</h5>
                                    <p>{!! $product->is_active ? '<i class="fas fa-check text-success"></i> Active' : '<i class="fas fa-times text-danger"></i> Inactive' !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Image:</h5>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="img-fluid">
                                    @else
                                        <p>No image available</p>
                                    @endif

                                    <h5 class="font-weight-bold">Available Colors:</h5>
                                    <ul>
                                        @foreach ($product->colors as $color)
                                            <li>{{ $color->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <h2>Comments</h2>
                                @foreach ($comments as $comment)
                                    <div class="mb-3">
                                        <p><strong>{{$comment->user->name}}</strong></p>
                                        <p>{{ $comment->body }}</p>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('comments.store', $product->slug) }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <textarea class="form-control" name="body" placeholder="Your comment here" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Comment</button>
                            </form>

                            <!-- MODAL BEGINS HERE -->
                            <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('carts.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="quantity">Quantity:</label>
                                                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="color">Select Color:</label>
                                                    <select id="color" name="color" class="form-control" required>
                                                        <option value="">Select Color</option>
                                                        @foreach ($product->colors as $color)
                                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL ENDS HERE -->

                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <button class="btn btn-outline-dark mt-auto" data-bs-toggle="modal" data-bs-target="#addToCartModal">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-frontend.master>
