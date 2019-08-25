@extends('admin.layouts.master')

@section('page')
    View Products
@endsection

@push('css')
    @endpush

@section('content')
    <div class="row">

        <div class="col-md-12">
            @include('admin.layouts.message')
            <div class="card">
                <div class="header">
                    <h4 class="title">All Products</h4>
                    <p class="category">List of all stock</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Name</th>
                            <th width="10%">Price</th>
                            <th width="25%">Desc</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>${{ $product->price }}</td>
                            <td>{{ $product->description }}</td>
                            <td><img src="{{ asset('uploads/'.$product->image) }}" alt="" class="img-thumbnail"
                                     style="width: 50px"></td>
                            <td>

                                <a href="{{ route('products.edit',$product->id) }}" class="btn btn-sm btn-info ti-pencil-alt" title="Edit"></a>
                                <a href="{{ route('products.show',$product->id) }}" class="btn btn-sm btn-primary ti-eye" title="Details"></a>

                                <form action="{{ route('products.destroy',$product->id) }}" method="post" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick='return confirm("Are you sure Want to delete this?")' type="submit" class="btn btn-sm btn-danger ti-trash" title="Delete"></button>
                                </form>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @endpush