<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Todos') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
 
    <!-- JQuery Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
<!-- Your existing HTML code for the layout -->         
        </main>

        

<!-- Include the JavaScript code -->
@section('scripts')
<script>
    // Get the status select elements
    var statusSelects = document.querySelectorAll('.status-select');

    // Add event listener to handle status change for each select element
    statusSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            // Get the selected status
            var selectedStatus = this.value;

            // Get the parent row element
            var row = this.closest('td');

            // Reset the color
            row.style.color = '';

            // Change the color to blue for "In progress" status
            if (selectedStatus === 'In progress') {
                row.style.color = 'blue';
            }
        });
    });
</script>
@endsection
        </div>    
    </body>
</html>
