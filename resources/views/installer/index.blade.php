<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMail Full Warez</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" as="style" href="{{ asset('css/vendor.css') }}" onload="this.onload=null;this.rel='stylesheet'">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <main class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="pt-12" style="font-size:2em">
                    <center><h1>TMail Full Warez Ver 7.8.1<br>Groot Theme incluse</h1></center>
                </div>
                <div class="p-10">
                    @livewire('installer.installer')
                </div>
            </div>
        </div>
    </main>
    @livewireScripts
</body>
</html>