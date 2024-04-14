@extends('admin.layouts.main')

@section('content')
    <div class="container d-flex justify-content-center">
        <form class="mt-4" action="{{route('setupSettings')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <canvas id="drawingCanvas" style="border: 1px solid rgba(227, 224, 224, 0.5);
    display: block;
    width: 400px;
    height: 600px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    border-radius: 15px;" ></canvas>

            <input class="form-control col-12 mt-3 mb-2" type="file" name="fileToUpload" id="fileToUpload">
            <label>Time interval</label>
            <input class="form-control col-12" value="{{auth()->user()->interval}}" type="number" name="interval" required>
            <label>Name</label>
            <input class="form-control col-12 " value="{{auth()->user()->site_name}}" type="text" name="site_name" id="fileToUpload" required>

            <label>From Time</label>
            <input type="time" name="from_time" class="form-control" value="{{auth()->user()->from_time}}" required />
            <label>To Time</label>
            <input type="time" name="to_time" class="form-control" value="{{auth()->user()->to_time}}" required  />
            <label>Image background</label>
            <input class="form-control col-12 mt-3 mb-2" type="file" name="backgroundFile" id="fileToUpload">

            <input class="mt-2 w-100 btn btn-primary" type="submit" value="Save settings" name="submit">
        </form>
    </div>
@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#fileToUpload').change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imageUrl = e.target.result;
                        var canvas = document.getElementById("drawingCanvas");
                        canvas.style.backgroundImage = "url('" + imageUrl + "')";
                    }
                    reader.readAsDataURL(file);
                }
            });

        });
    </script>
@endpush
