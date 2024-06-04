<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])

    <title>Contas</title>

    <style>
       .styled-header {
            border: 1px solid #ccc;
            border-radius: 10px;
            background: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Aqui aumentei a sombra */
            margin-top: 20px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="styled-header d-flex flex-wrap justify-content-center py-3 mb-4">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                <span class="fs-4" style="color: black;">Contas</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item me-2"><a href="{{ route('conta.index') }}" class="nav-link active" aria-current="page">Home</a></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link active" aria-current="page">
                        Logout
                    </button>
                </form>
            </ul>
        </header>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
