<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Notification</label>
                            <div class="col-md-6">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Administrator approved your table from {{$start}} to {{$end}}</strong>
                                    </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

