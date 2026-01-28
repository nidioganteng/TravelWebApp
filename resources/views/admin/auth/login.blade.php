<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mijn Amor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <h1 class="text-2xl font-bold text-white font-serif italic">Mijn Amor</h1>
            <p class="text-blue-100 text-sm mt-1">Administrator Portal</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required autofocus>
                    @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="/" class="text-xs text-gray-400 hover:text-gray-600">Kembali ke Website Utama</a>
            </div>
        </div>
    </div>

</body>

</html>