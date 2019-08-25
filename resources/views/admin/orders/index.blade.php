@extends('admin.layouts.master')

@section('page')
    Order
@stop

@push('css')
    @endpush

@section('content')
    <div class="row">

        <div class="col-md-12">
            @include('admin.layouts.message')
            <div class="card">
                <div class="header">
                    <h4 class="title">Orders</h4>
                    <p class="category">List of all orders</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>


                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    @foreach($order->Products as $item)
                                        <table class="table">
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                            </tr>
                                        </table>

                                        @endforeach
                                </td>

                                <td>
                                    @foreach($order->OrderItems as $item)
                                        <table class="table">
                                            <tr>
                                                <td>{{ $item->quantity }}</td>
                                            </tr>
                                        </table>

                                    @endforeach
                                </td>
                                <td>{{ $order->address }}</td>
                                <td>
                                    @if($order->status == 0)
                                    <span class="label label-warning">Pending</span>
                                        @else
                                        <span class="label label-success">Confirmed</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 1)

                                        <a href="{{ route('orders.pending',$order->id) }}" class="btn btn-sm btn-warning ti-close"
                                           title="Cancel Order"></a>
                                        @else

                                        <a href="{{ route('orders.confirmed',$order->id) }}" class="btn btn-sm btn-success ti-check"
                                           title="Confirmed Order"></a>
                                    @endif

                                    <a href="{{ route('orders.show',$order->id) }}" class="btn btn-sm btn-primary ti-view-list-alt"
                                            title="Details"></a>
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