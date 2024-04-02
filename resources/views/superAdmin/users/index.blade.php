@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
            </thead>


            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{$user->name}}</td>

                    <td><a href="{{route('user.edit', $user->id)}}"><i class="fas fa-pencil-alt"></i></a></td>
                    <td>
                        <form action="{{route('user.delete',$user->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="bg-transparent border-0">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
@endsection
