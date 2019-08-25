@extends('admin.layouts.master')

@section('page')
    Product Edit
@endsection

@push('css')
    <style>
        .thumb{
            margin: 10px 5px 0 0;
            width: 100px;
        }
        #images{
           margin-top: 10px;
        }
    </style>
    @endpush

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10">
            @include('admin.layouts.message')
            <div class="card">
                <div class="header">
                    <h4 class="title">Edit Product</h4>
                </div>
                <div class="content">
                    <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" {{ $errors->has('name') ? 'has-error' : '' }}>
                                    <label>Product Name:</label>
                                    <input value="{{ $product->name }}" type="text" name="name" class="form-control border-input" placeholder="Macbook pro">
                                    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="form-group" {{ $errors->has('name') ? 'has-error' : '' }}>
                                    <label>Product Price:</label>
                                    <input value="{{ $product->price }}" type="text" name="price" class="form-control border-input" placeholder="$2500">
                                    <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
                                </div>

                                <div class="form-group" {{ $errors->has('name') ? 'has-error' : '' }}>
                                    <label>Product Description:</label>
                                    <textarea name="description" id="" cols="30" rows="10"
                                              class="form-control border-input" placeholder="Product Description">{{ $product->description }}</textarea>
                                    <span class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                </div>

                                <div class="form-group" {{ $errors->has('name') ? 'has-error' : '' }}>
                                    <label>Product Image:</label>
                                    <input type="file" id="file-input" name="image" class="form-control border-input">
                                    <div id="thumb-output"></div>
                                    <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                    <div id="images">
                                        <img src="{{ asset('uploads/'.$product->image) }}" alt="" style="width: 100px;">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Add Product</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('#file-input').on('change', function(){ //on file input change
                if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                {
                    $('#thumb-output').html(''); //clear html of output element
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                                    $('#thumb-output').append(img); //append image to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });

                }else{
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
    @endpush