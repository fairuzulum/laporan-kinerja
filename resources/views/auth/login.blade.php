<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-blue-800 mb-6 text-center">Login</h1>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email
                </label>
                <input type="email" name="email" id="email" required class="w-full border rounded p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <input type="password" name="password" id="password" required class="w-full border rounded p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
        </form>
    </div>
</body>
</html>