<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('MijnAmor.svg') }}" type="image/svg">
    <title>Mijn Amor Travel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen w-full overflow-hidden flex items-center justify-center bg-gray-900"
      x-data="{ 
          activeSlide: 0, 
          slides: [
              '{{ asset('img/admin/login/assets/view_one.svg') }}',
              '{{ asset('img/admin/login/assets/view_two.svg') }}',
              '{{ asset('img/admin/login/assets/view_three.svg') }}'
          ] 
      }"
      x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000)">

    <div id="slider-container" class="absolute inset-0 z-0">
        <template x-for="(slide, index) in slides" :key="index">
            <div class="slide-bg absolute inset-0 bg-cover bg-center"
                 :style="`background-image: url('${slide}');`"
                 x-show="activeSlide === index"
                 x-transition:enter="transition ease-in-out duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in-out duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-black/40"></div> </div>
        </template>
    </div>

    <div class="relative z-10 w-full max-w-100 p-8 mx-4">
        <div class="absolute inset-0 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 shadow-2xl"></div>

        <div class="relative z-20 text-center px-4 py-6">
            
            <h1 class="text-4xl font-bold text-white mb-8 text-left">Login</h1>
            <p class="text-gray-200 text-xs font-light mb-8 opacity-80 text-left">Welcome back! Please login your account</p>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div class="relative group">
                    <input type="email" name="email" placeholder="Email address"
                        class="w-full bg-transparent border border-white/30 rounded-lg py-3 px-4 text-white placeholder-gray-300 text-sm focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all"
                        required autofocus>
                    <span class="absolute right-4 top-3.5 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    @error('email')
                        <p class="text-red-300 text-xs text-left mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative group">
                    <input type="password" name="password" placeholder="Password"
                        class="w-full bg-transparent border border-white/30 rounded-lg py-3 px-4 text-white placeholder-gray-300 text-sm focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all"
                        required>
                    <span class="absolute right-4 top-3.5 text-gray-300 cursor-pointer hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>
                </div>

                <button type="submit" class="w-full bg-[#0099FF] hover:bg-[#0066FF] text-white font-semibold py-3 px-4 rounded-lg shadow-lg transform active:scale-95 transition duration-200 mt-6">
                    Login
                </button>
            </form>

            <div class="mt-6">
                <a href="/" class="text-xs text-gray-300 hover:text-white transition">Back to Main Website</a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index" 
                    class="h-1.5 w-8 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'bg-white opacity-100' : 'bg-white opacity-40'">
            </button>
        </template>
    </div>

</body>
</html>