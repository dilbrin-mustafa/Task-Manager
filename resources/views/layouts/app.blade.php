<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Manager</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .sortable-ghost {
            background-color: #cceeff;
            opacity: 0.7;
            border: 2px dashed #007bff;
            border-radius: 0.5rem; /* rounded-lg */
        }
    </style>
</head>
<body class="bg-gray-100 antialiased">

<div class="absolute top-0 left-0 w-full h-72 bg-gradient-to-r from-blue-600 to-indigo-700 transform -skew-y-3 origin-top-left"></div>

<div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl">
        @yield('content')
    </div>
</div>

</body>
</html>
