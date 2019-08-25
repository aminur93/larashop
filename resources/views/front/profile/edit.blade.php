@extends('front.layouts.master')

@section('page')
    User profile Edit
@stop

@push('css')
    @endpush

@section('content')
    <div class="row">

        <div class="col-md-12" id="register">

            <div class="card col-md-8">
                <div class="card-body">
                    <h2 class="card-title">Update User Profile</h2>
                    <hr>

                    @include('front.layouts.message')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/user/profile/update',$user->id) }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" value="{{ $user->name }}" name="name" placeholder="Name" id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" value="{{ $user->email }}" name="email" placeholder="Email" id="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" placeholder="Password" id="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" name="password_confirmation" placeholder="Password Confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address" placeholder="Address" id="address" class="form-control">{{ $user->address }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info col-md-2"> Submit</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
@stop

@push('js')
    @endpush