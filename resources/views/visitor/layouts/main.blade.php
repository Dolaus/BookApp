<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Малювання зображень</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/3f9b90c861.js" crossorigin="anonymous"></script>


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
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MyCatCafe</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('user.index')}}">Users <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>

<div class="Mycontainer">
    @yield('content')
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
    });
</script>
<script src="{{ asset('js/jquery.bs.calendar.min.js') }}"></script>
    @stack('js')
</body>
</html>
