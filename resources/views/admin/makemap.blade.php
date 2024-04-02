@extends('admin.layouts.main')

@section('content')
    <div class="MyContainer">
        <div class="d-flex text-center" id="canvas-container">
            <canvas id="drawingCanvas"></canvas>
            @foreach($user->tables as $table)
                <img src="https://via.placeholder.com/50" width="50" height="50" class="image" style="left: {{$table['x']}}px; top: {{$table['y']}}px;">
            @endforeach


        </div>
    </div>
    <div class="d-flex justify-content-center mt-2">
    <button id="deleteButton" class="btn btn-danger">Режим видалення</button>
    <button id="logButton" class="btn btn-info">Режим логування</button>
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
                img.src = 'https://via.placeholder.com/50'; // Змініть шлях на шлях до вашого зображення
                img.setAttribute('width', '50');
                img.setAttribute('height', '50');
                img.style.left = (x - 25) + 'px'; // Розміщення по центру кліку
                img.style.top = (y - 25) + 'px'; // Розміщення по центру кліку
                img.setAttribute('class', 'image');

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

            // function deleteImage(x, y) {
            //     $.ajax({
            //
            //         url: '/saveTabвle',
            //         method: 'POST',
            //         data: 1,
            //         success: function(response) {
            //             console.log("Good");
            //         },
            //         error: function(error) {
            //             console.error('Error:', error);
            //         }
            //     });
            //     const elements = document.elementsFromPoint(x, y);
            //     console.log('elements');
            //     console.log(elements);
            //     elements.forEach(element => {
            //         if (element.classList.contains('image')) {
            //             console.log('element');
            //             console.log(element);
            //             element.remove();
            //
            //             const index = buttons.indexOf(element);
            //             if (index !== -1) {
            //                 buttons.splice(index, 1);
            //             }
            //         }
            //     });
            // }

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

            document.getElementById('logButton').addEventListener('click', function() {
                logMode = !logMode;
                this.classList.toggle('log-mode', logMode);
                if (logMode) {
                    buttons.forEach(button => {
                        button.addEventListener('click', logCoordinates);
                    });
                } else {
                    buttons.forEach(button => {
                        button.removeEventListener('click', logCoordinates);
                    });
                }
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
