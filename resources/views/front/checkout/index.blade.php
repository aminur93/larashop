@extends('front.layouts.master')

@section('page')
    CheckOut
@stop

@push('css')
    <style>
        /**
  * The CSS shown here will not be introduced in the Quickstart guide, but shows
  * how you can use CSS to style your Element's container.
  */
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
    @endpush

@section('content')
    <h2 class="mt-5"><i class="fa  fa-credit-card-alt"></i> Checkout</h2>
    <hr>

    <div class="row">

        <div class="col-md-7">
            @if (session()->has('msg'))
                <div class="alert alert-success">
                    {{ session()->get('msg') }}
                </div>
            @endif

            <h4>Billing Details</h4>

            <form method="post" id="payment-form" action="{{ route('checkout') }}">@csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="City">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="provance">Provance</label>
                        <input type="text" name="provance" class="form-control" id="provance" placeholder="Provance">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="postal">Postal</label>
                        <input type="text" name="postal" class="form-control" id="postal" placeholder="Postal">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                </div>
                <hr>
                <h5><i class="fa fa-credit-card"></i> Payment Details</h5>

                <div class="form-group">
                    <label for="name_card">Name on card</label>
                    <input type="text" name="name_card" class="form-control" id="name_card" placeholder="Name on card">
                </div>

                <div class="form-group">
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>

                <button type="submit" class="btn btn-outline-info col-md-12">Complete Order</button>
            </form>

        </div>

        <div class="col-md-5">

            <h4>Your Order</h4>

            <table class="table your-order-table">
                <tr>
                    <th>Image</th>
                    <th>Details</th>
                    <th>Qty</th>
                </tr>
                @foreach(Cart::instance('default')->content() as $item)
                <tr>
                    <td><img src="{{ asset('/uploads/'.$item->model->image) }}" alt="" style="width: 4em"></td>
                    <td>
                        <strong>{{ $item->model->name }}</strong><br>
                        {{ $item->model->description }} <br>
                        <span class="text-dark">${{ $item->total() }}</span>
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $item->qty }}</span>
                    </td>
                </tr>
                    @endforeach

            </table>

            <hr>
            <table class="table your-order-table table-bordered">
                <tr>
                    <th colspan="2">Price Details</th>
                </tr>
                <tr>
                    <td>Subtotal</td>
                    <td>${{Cart::subtotal() }}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>${{ Cart::tax() }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>${{ Cart::total() }}</th>
                </tr>

            </table>

        </div>
    </div>

    <br><br>
@stop

@push('js')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_x04rVJt4saDAcvbFTvk0Q2xU');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            var options = {
                name: document.getElementById("name_card").value,
                address_line_1: document.getElementById("address").value,
                address_city: document.getElementById("city").value,
                address_provance: document.getElementById("provance").value,
                address_postal: document.getElementById("postal").value,
            };

            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
    @endpush