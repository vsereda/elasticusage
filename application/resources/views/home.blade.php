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
    <nav class="main-router-wrapper">
        <router-link to="/">HOME</router-link>
        <router-link to="/article/1">ARTICLE</router-link>
    </nav>
    <hr>
    <router-view></router-view>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
