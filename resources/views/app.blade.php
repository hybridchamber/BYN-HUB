<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
    
    <!-- Google Maps JavaScript API -->
    <script 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTou7SZEbSRKX37-awgtPfz48wSnlWUp0&libraries=places"
        async 
        defer>
    </script>
</body>


</html>
