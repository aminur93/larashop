@extends('admin.layouts.master')

@section('page')
    User Orders Details
@stop

@push('css')
    @endpush

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">{{ $orders[0]->user->name }}</h4>
                    <p class="category">Order Details</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($orders as $order)
                                <tr>
                                <tr>

                                    <td>{{ $order->id }}</td>

                                    <td>
                                        @foreach ($order->products as $item)
                                            <table class="table">
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($order->orderItems as $item)
                                            <table class="table">
                                                <tr>
                                                    <td>{{ $item->quantity }}</td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($order->orderItems as $item)
                                            <table class="table">
                                                <tr>
                                                    <td>${{ $item->price }}</td>
                                                </tr>
                                            </table>
                                        @endforeach
                                    </td>


                                    <td>
                                        @if($order->status)
                                            <span class="label label-success">Confirmed</span>
                                        @else
                                            <span class="label label-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    @endpush