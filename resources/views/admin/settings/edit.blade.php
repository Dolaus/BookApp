@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <form action="{{route('setupSettings')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <canvas id="drawingCanvas" ></canvas>

            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
            <input class="mt-2 btn btn-primary" type="submit" value="Save settings" name="submit">
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
