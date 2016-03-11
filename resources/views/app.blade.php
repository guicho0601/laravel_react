<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autorefresh</title>
    <link href="<?=asset('css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=asset('css/font-awesome.min.css')?>" rel="stylesheet">
    <link href="<?=asset('css/jquery-confirm.min.css')?>" rel="stylesheet">

    <script src="<?=asset('js/jquery.min.js')?>"></script>
    <script src="<?=asset('js/bootstrap.min.js')?>"></script>
    <script src="<?=asset('js/jquery-confirm.min.js')?>"></script>
    <script src="<?=asset('build/react.js')?>"></script>
    <script src="<?=asset('build/react-dom.js')?>"></script>
    <script src="<?=asset('build/browser.min.js')?>"></script>
    <script src="<?=asset('build/marked.min.js')?>"></script>
    @yield('header')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>