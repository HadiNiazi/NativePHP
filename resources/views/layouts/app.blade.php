<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker - Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 font-sans min-h-screen">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
