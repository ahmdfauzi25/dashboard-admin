<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HiddenGame</title>
        @vite(['resources/sass/app.scss', 'resources/js/main.js'])
    </head>
    <body class="bg-[#0f0f0f]">
        <div id="app"></div>
    </body>
</html>


