<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ddd</title>
    <!-- Bootstrap CSS -->
     <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <div class="d-flex vh-100">
        {{-- Sidebar --}}
        <div class="flex-shrink-0 bg-white border-end" style="width: 250px;">
            @include('partials.sidebar')
        </div>

        {{-- Contenu principal --}}
        <div class="flex-grow-1 d-flex flex-column">
            
            {{-- Topbar --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    @include('partials.topbare')
                </div>
            </nav>

            {{-- Contenu de la page --}}
            <main class="flex-grow-1 p-4 overflow-auto">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>
