<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Elastic usage</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <router-link to="/">Home</router-link>
    <router-link to="/about">About</router-link>
    <hr>
    <router-view></router-view>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
