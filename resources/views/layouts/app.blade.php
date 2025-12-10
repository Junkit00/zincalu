<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parts System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-56 bg-white border-r h-screen fixed left-0 top-0 flex flex-col">
        <div class="p-6 text-xl font-bold">
            LOGO
        </div>

        <nav class="space-y-2 px-4">
            <a href="{{ route('dashboard') }}" class="block bg-gray-200 py-2 px-4 rounded">Dashboard</a>
            <a href="#" class="block bg-gray-200 py-2 px-4 rounded">Account</a>
            <a href="{{ route('parts.manage') }}" class="block bg-gray-200 py-2 px-4 rounded">Manage</a>
        </nav>
    </aside>

    <!-- Main content container -->
    <div class="flex-1 ml-56">

        <!-- Top bar -->
        <header class="flex justify-between items-center p-4 bg-white border-b">
            <div></div>
            <div class="flex gap-2">
                <button class="border px-3 py-1 rounded">Sign in</button>
                <button class="border px-3 py-1 rounded">Register</button>
            </div>
        </header>

        <main class="p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>
