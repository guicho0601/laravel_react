<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autorefresh</title>
    <link href="<?=asset('css/app.css')?>" rel="stylesheet">
    @yield('header')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script>
        var global_url = '<?=url('/')?>';
        var csrf_token = '<?=csrf_token()?>';
    </script>
    <script src="<?=asset('js/jquery.min.js')?>"></script>
    <script src="<?=asset('js/main.js')?>"></script>
    @yield('scripts')
</body>
</html>