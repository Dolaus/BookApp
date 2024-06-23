@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Notification</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <span><strong>You reserved table ID {{$table}} from {{$start}} to {{$end}}</strong><br></span>

                            <span>Pls wait when administrator approve you booking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




