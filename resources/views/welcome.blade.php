<x-frontend.master>
    <x-slot:title>
        SiS | Home
    </x-slot>
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach($products as $product)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="{{ asset($product->image) }}" style="width:100%; height: 225px;" alt="{{$product->title}}" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">{{$product->title}}</h5>
                            BDT {{$product->price}}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-outline-dark mt-auto" href="{{route('product_details', $product->slug)}}">View Product</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <ul class="pagination pagination-sm">
            {{$products->links('vendor.pagination.bootstrap-5')}}
        </ul>
    </div>
</x-frontend.master>