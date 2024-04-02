@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <form action="{{route('user.update')}}" method="POST">
            @csrf
            @method('PUT')
            <input name="user_id" value="{{$user->id}}" hidden required>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" value="{{$user->name}}" name="name" class="form-control"
                       placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input value="{{$user->email}}" type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Enter email" required>
            </div>
            @error('email')
            <div class="text-danger">{{@$message}}</div>
            @enderror

            <div class="form-group">
                <label>New password</label>
                <input type="text" name="password" class="form-control">
                @error('password')
                <div class="text-danger">{{@$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
