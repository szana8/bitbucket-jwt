<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet" type="text/css">

        <!-- Scripts -->
        <script>
            window.Laravel = '{!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!}';
        </script>

        <title>Laravel</title>

    </head>
    <body>
        <div id="app">
            <app></app>
        </div>

        <script src="js/app.js"></script>
    </body>
</html>
