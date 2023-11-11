<x-frontend.master>
    <x-slot name="title">SiS | Cart</x-slot>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Shopping Cart</h3>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (count(auth()->user()->cartProducts) > 0)
                            <form action="{{route('orders.store')}}" method="post">
                                @csrf
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (auth()->user()->cartProducts as $key => $item)
                                            <tr>
                                                <input type="hidden" name="products[{{$key}}][cart_product_id]" value="{{$item->id}}">
                                                <td>{{ $item->product->title }}{{$item->color ? ' - '.$item->color->name:null}}</td>
                                                <td>{{ $item->product->price }}</td>
                                                <td>
                                                    <div class="input-group">
                                                        {{-- minus button --}}
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default minus-btn">
                                                                <span class="fas fa-minus"></span>
                                                            </button>
                                                        </span>
                                                            {{-- input field --}}
                                                        <input type="number" 
                                                               name="products[{{$key}}][quantity]"
                                                               class="form-control" 
                                                               value="{{ $item->quantity }}" 
                                                               data-id="{{$item->id}}">
                                                               {{-- plus button --}}
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default plus-btn">
                                                                <span class="fas fa-plus"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="price">{{ $item->product->price * $item->quantity }}</td>
                                                <td class="btn btn-outline-danger remove-btn" data-id="{{$item->id}}">Remove</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="3"><b>Total : </b></td>
                                                <td class="text-center"><span id="totalprice">0</span></td>
                                            </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label><b>Contanct Number : </b></label>
                                        <input class="form-control" type="text" name="contact_no" placeholder="+880123456789" />
                                    </div>
                                    <div class="col-md-6">
                                        <label><b>Shipping Address : </b></label>
                                        <textarea class="form-control" type="textarea" name="address" placeholder="Chittagong"></textarea>
                                    </div>                                    
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                                </div>
                            </form>
                            @else
                                <p>Your shopping cart is empty.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        <script>
            const removeBtn = document.querySelectorAll('.remove-btn');

            removeBtn.forEach(function(btn)
            {
                btn.addEventListener('click',function()
                {
                    const id = btn.getAttribute('data-id');

                    fetch('/admin/carts/'+id,
                    {
                        method : 'DELETE',
                        headers : 
                        {
                            'X-CSRF-TOKEN' : '{{csrf_token()}}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => 
                    {
                        if(data.success == true)
                        {
                            btn.parentElement.remove()
                            updatingPrice()
                            alert(data.message)
                        }
                        else
                        {
                            alert('Couldn\'t remove item from cart')
                        }
                    })

                })
            })

            // update

           // const updateQuantity = document.querySelectorAll('.quantity');

            const increase = document.querySelectorAll('.plus-btn');

            increase.forEach(function(btn)
            {
                btn.addEventListener('click', function()
                {
                    const quantity = this.parentElement.previousElementSibling;

                    if(quantity.value == 20)
                    {
                        alert('Maximum Order limit reached');
                        return;
                    }

                    const updatedQuantity = parseInt(quantity.value)+1;
                    quantity.value = updatedQuantity

                    const priceElement = quantity.parentElement.parentElement.previousElementSibling;
                    const updatePrice = parseFloat(priceElement.innerText) * updatedQuantity;

                    priceElement.nextElementSibling.nextElementSibling.innerText = updatePrice;

                    updatingPrice()

                })
            })

            const decrease = document.querySelectorAll('.minus-btn');

            decrease.forEach(function(btn)
            {
                btn.addEventListener('click', function()
                {
                    const quantity = this.parentElement.nextElementSibling;

                    if(quantity.value == 1)
                    {
                        alert('Any less than 1 is not acceptable, the remove button is to the right in RED');
                        return;
                    }

                    const updatedQuantity = parseInt(quantity.value)-1;
                    quantity.value = updatedQuantity

                    const priceElement = quantity.parentElement.parentElement.previousElementSibling;
                    const updatePrice = parseFloat(priceElement.innerText) * updatedQuantity;

                    priceElement.nextElementSibling.nextElementSibling.innerText = updatePrice;

                    updatingPrice()

                })
            })

            //end of update

            updatingPrice()

            function updatingPrice()
            {
                const amount = document.querySelectorAll('.price')

                let totalprice = 0;
                amount.forEach(function(element)
                {
                    totalprice += parseFloat(element.innerText);
                    document.getElementById('totalprice').innerText = totalprice
                })
            }

        </script>
    @endpush
</x-frontend.master>
