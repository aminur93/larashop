@extends('front.layouts.master')

@section('page')
    Cart
@stop

@push('css')
    @endpush

@section('content')
    <h2 class="mt-5"><i class="fa fa-shopping-cart"></i> Shopping Cart</h2>
    <hr>

    @if(Cart::instance('default')->count() > 0)

    <h4 class="mt-5">{{ Cart::instance('default')->count() }} items(s) in Shopping Cart</h4>

    <div class="cart-items">

        <div class="row">

            <div class="col-md-12">

                @if (session()->has('msg'))
                    <div class="alert alert-success">
                        {{ session()->get('msg') }}
                    </div>
                @endif

                    @if ( session()->has('errors') )

                        <div class="alert alert-warning">{{ session()->get('errors') }}</div>

                    @endif

                <table class="table">

                    <tbody>

                    @foreach(Cart::instance('default')->content() as $item )

                    <tr>
                        <td><img src="{{ asset('uploads/'.$item->model->image) }}" style="width: 5em"></td>
                        <td>
                            <strong>{{ $item->model->name }}</strong><br> {{ $item->model->description }}
                        </td>

                        <td>
                            <form action="{{ route('cart.destroy',$item->rowId) }}" method="post">
                                @csrf
                                @method('delete')
                                <button style="cursor: pointer;" type="submit" class="btn btn-link btn-link-dark">Remove</button>
                            </form>

                            <form action="{{ route('cart.saveLater',$item->rowId) }}" method="post">
                                @csrf
                                <button style="cursor: pointer;" type="submit" class="btn btn-link btn-link-dark">Save for later</button>
                            </form>


                        </td>

                        <td>
                            <select data-id="{{ $item->rowId }}" class="form-control quantity" style="width: 4.7em">
                                @for ($i = 1; $i < 5 + 1; $i++)
                                    <option {{ $item->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                            </select>
                        </td>

                        <td>${{ $item->total() }}</td>
                    </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
            <!-- Price Details -->
            <div class="col-md-6">
                <div class="sub-total">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2">Price Details</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Subtotal </td>
                            <td>${{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal() }} </td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>${{ \Gloudemans\Shoppingcart\Facades\Cart::tax() }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>${{ \Gloudemans\Shoppingcart\Facades\Cart::total() }}</th>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- Save for later  -->
            <div class="col-md-12">
                <a href="{{ url('/') }}" class="btn btn-outline-dark">Continue Shopping</a>
                <a href="{{ url('/checkout') }}" class="btn btn-outline-info">Proceed to checkout</a>
                <hr>

            </div>

            @else
                <h2>There is no item in your cart</h2>
                <a href="{{ url('/') }}" class="btn btn-outline-dark">Continue Shopping</a>
                <hr>
            @endif
            
            @if (Cart::instance('saveForLater')->count() > 0)
                <div class="col-md-12">

                    <h4>{{ Cart::instance('saveForLater')->count() }} items Save for Later</h4>
                    <table class="table">

                        <tbody>
                        @foreach(Cart::instance('saveForLater')->content() as $item )

                            <tr>
                                <td><img src="{{ asset('uploads/'.$item->model->image) }}" style="width: 5em"></td>
                                <td>
                                    <strong>{{ $item->model->name }}</strong><br> {{ $item->model->description }}
                                </td>

                                <td>
                                    <form action="{{ route('saveLater.destroy',$item->rowId) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="cursor: pointer;" type="submit" class="btn btn-link btn-link-dark">Remove</button>
                                    </form>

                                    <form action="{{ route('saveLater.moveToCart',$item->rowId) }}" method="post">
                                        @csrf
                                        <button style="cursor: pointer;" type="submit" class="btn btn-link btn-link-dark">Move to cart</button>
                                    </form>


                                </td>

                                <td>
                                    <select name="" id="" class="form-control" style="width: 4.7em">
                                        <option value="">1</option>
                                        <option value="">2</option>
                                    </select>
                                </td>

                                <td>${{ $item->total() }}</td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>

                </div>
            @endif

        </div>


    </div>
@stop

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>

        const className = document.querySelectorAll('.quantity');

        Array.from(className).forEach(function (el) {
            el.addEventListener('change',function () {
                const id = el.getAttribute('data-id');
                axios.patch('/cart/update/'+id, {
                    quantity: this.value
                })
                    .then(function (response) {
                        //console.log(response);
                        location.reload();
                    })
                    .catch(function (error) {
                        //console.log(error);
                        location.reload();
                    });
            });
        });
    </script>
    @endpush