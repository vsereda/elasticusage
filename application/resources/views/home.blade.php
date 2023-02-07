<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="api-base-url" content="{{ url('') }}"/>
    <title>Elastic usage</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="main-router-wrapper">
        <router-link to="/">Home</router-link>
        <router-link to="/articles/create">New article</router-link>
        <router-link to="/articles/search">Search articles</router-link>
    </nav>
    <hr>
    <router-view></router-view>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
