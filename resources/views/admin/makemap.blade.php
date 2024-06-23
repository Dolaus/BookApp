@extends('admin.layouts.main')

@section('content')
    <div class="MyContainer">
        <div class="d-flex mt-4 text-center" id="canvas-container">
            <canvas id="drawingCanvas" style="border: 1px solid rgba(227, 224, 224, 0.5);
    display: block;
    width: 400px;
    height: 600px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    border-radius: 15px;  background-image: url('{{asset('images/table.png')}}');"></canvas>
            @foreach($user->tables as $table)
                <img  src="{{asset('images/SimpleTable.png')}}" width="42" height="42" class="image imageAbsolute" style="left: {{$table['x']}}px; top: {{$table['y']}}px;">
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-2">
    <button id="deleteButton" class="btn btn-danger">Delete table</button>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {

            let userId = $('#userID').val();
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log('userId');
            console.log(userId);
            console.log('csrfToken');
            console.log(csrfToken);

            const canvas = document.getElementById('drawingCanvas');
            const ctx = canvas.getContext('2d');
            let deleteMode = false;
            let logMode = false;
            const buttons = [];

            canvas.addEventListener('click', function(event) {
                const rect = canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;

                if (!deleteMode) {
                    createImage(x, y);
                } else {
                    deleteImage(x, y);
                }
            });

            function createImage(x, y) {
                const img = document.createElement('img');
                img.src = '{{asset('images/SimpleTable.png')}}';
                img.setAttribute('width', '30');
                img.setAttribute('height', '30');
                img.style.left = (x - 25) + 'px';
                img.style.top = (y - 25) + 'px';
                img.setAttribute('class', 'image');
                img.setAttribute('class', 'imageAbsolute');

                img.addEventListener('click', function() {
                    if (deleteMode) {
                        this.remove();
                        const index = buttons.indexOf(this);
                        if (index !== -1) {
                            buttons.splice(index, 1);
                        }
                    }
                });
                console.log(img);
                buttons.push(img);

                let dataToSend = {
                    x: x - 25,
                    y: y - 25,
                    userId: userId
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    url: '/saveTable',
                    method: 'POST',
                    data: dataToSend,
                    success: function(response) {
                        console.log("Good");
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });




                document.getElementById('canvas-container').appendChild(img);
            }


            document.getElementById('deleteButton').addEventListener('click', function() {
                deleteMode = !deleteMode;
                $('.image').click(function(){
                    let x = $(this).css('left');
                    let y = $(this).css('top');

                    $(this).remove();
                    let dataToSend = {
                        x: x,
                        y: y,
                        userId: userId
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        url: '/deleteTable',
                        method: 'DELETE',
                        data: dataToSend,
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });



            function logCoordinates() {
                const rect = this.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;
                console.log(`Натиснуто на координатах (${x}, ${y})`);
            }
        });
    </script>
@endpush
