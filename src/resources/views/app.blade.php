<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Homecarehub Technical Task</title>
    <link rel="stylesheet" href="{{ mix('css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    <script type="text/javascript">window.csrf_token = "{{ csrf_token() }}"</script>
</head>
<body class="blank hide-sidebar sidebar-scroll fixed-footer">
<div id="app"></div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
