<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/newhome.js') }}"></script>
    <link rel="stylesheet" href="../css/homestyle.css">
    <link rel="stylesheet" href="../css/image.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- <div class="hamburger-menu-container">
    <div class="hamburger-icon" id="hamburger-icon">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
</div>

<nav id="navbar" class="navbar">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/projects">Projects</a></li>
        <li><a href="/other-projects">Other Projects</a></li>
        <li><a href="/notes">Notes</a></li>
        @if (session('curruser'))
            <li><a href="/logout">Logout</a></li>
        @else
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        @endif
    </ul>
</nav> -->

</body>