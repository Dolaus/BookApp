@extends('visitor.layouts.main')

@section('content')
    <div class="MyContainer">
        <div class="d-flex justify-content-center text-center pt-4" id="canvas-container">
            <form action="{{route('makeBookPost')}}" method="POST">
                @csrf
                <input name="id" value="{{$id}}" hidden>
                <input name="start" value="{{$start}}" hidden>
                <input name="end" value="{{$end}}" hidden>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label text-light" style="width: 400px">Email</label>
                    <input name="email" type="email" class="form-control" required>
                </div>
                <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label text-light" style="width: 400px">Comment</label>
                <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" style="height: 200px" rows="3"></textarea>
            </div>
                <button type="submit" class="btn btn-primary myColor">Submit</button>
            </form>
        </div>
    </div>
@endsection
