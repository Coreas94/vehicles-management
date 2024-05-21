<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de vehiculos</title>
    @vite(['resources/js/app.js'])
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #app {
            display: flex;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <!-- Your menu content here -->
        </nav>
        <div class="content">
            <!-- Your content here -->
        </div>
    </div>
    <script>
        window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</body>
</html>
