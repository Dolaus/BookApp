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
    <button id="deleteButton" class="btn btn-danger">Режим видалення</button>
    <button id="logButton" class="btn btn-info">Режим логування</button>

@endsection
