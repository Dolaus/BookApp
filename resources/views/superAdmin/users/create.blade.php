@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <form action="{{route('user.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Enter email" required>
            </div>
            @error('email')
            <div class="text-danger">{{@$message}}</div>
            @enderror

            <div class="form-group">
                <label>New password</label>
                <input type="text" name="password" class="form-control" required>
                @error('password')
                <div class="text-danger">{{@$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
