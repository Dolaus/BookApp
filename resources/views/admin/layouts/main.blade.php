<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>

        .MyContainer{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #canvas-container {
            position: relative;
            background-image: url("dasd/asd");
            background-size: contain; /* Зберігає пропорції і розтягує зображення, щоб воно було повністю видимим */
            background-repeat: no-repeat; /* Вимикає повторення фонового зображення */
            background-position: center;
        }

        canvas {
            border: 1px solid #000;
            display: block;
            width: 400px;
            height: 600px;
        }

        .image {
            position: absolute;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('user.index')}}">Users <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
{{--            <li class="nav-item dropdown">--}}
{{--                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    Dropdown--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                    <a class="dropdown-item" href="#">Action</a>--}}
{{--                    <a class="dropdown-item" href="#">Another action</a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                </div>--}}
{{--            </li>--}}

        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-flex">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>
<meta name="csrf-token" content="{{ csrf_token() }}">
<input id="userID" value="{{auth()->user()->id}}" name="user_id" hidden>

<div class="Mycontainer">

    @yield('content')

</div>
<script src="https://kit.fontawesome.com/3f9b90c861.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

</body>
</html>
