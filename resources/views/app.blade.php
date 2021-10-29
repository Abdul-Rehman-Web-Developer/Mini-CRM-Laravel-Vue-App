<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
      
        <!-- Styles -->
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script>
            window.baseUrl = @json(url('/').'/api');
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
