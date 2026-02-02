@extends('layouts.app')

@section('content')

<!-- Back Button -->
<div class="mb-6 max-w-6xl mx-auto mt-4 px-4">
  <a 
    href="javascript:history.back()" 
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>

<section class="flex justify-center items-center min-h-screen bg-gray-300">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to Los Pawlos Hermanos</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif

    <form method="post" action="{{ route('login') }}" id="loginForm">
      @csrf
      <input type="hidden" name="is_incognito" id="isIncognito" value="false">
      
      <script>
        (async function() {
            const loginBtn = document.querySelector('button[type="submit"]');
            const hiddenInput = document.getElementById('isIncognito');

            async function detectIncognito() {
                // 1. Chrome/Chromium Quota Check (Most reliable 2025)
                if (navigator.storage && navigator.storage.estimate) {
                    const { quota } = await navigator.storage.estimate();
                    if (quota < 2147483648) return true; // Threshold increased to 2GB
                }
                // 2. Legacy Chrome/Edge FileSystem Check
                const fs = window.RequestFileSystem || window.webkitRequestFileSystem;
                if (fs) {
                    let isPrivate = await new Promise(resolve => {
                        fs(window.TEMPORARY, 100, () => resolve(false), () => resolve(true));
                    });
                    if (isPrivate) return true;
                }
                // 3. ServiceWorker Check (Firefox)
                if (!navigator.serviceWorker && (navigator.userAgent.indexOf("Firefox") !== -1)) return true;
                
                // 4. IndexedDB Check (Safari)
                try {
                    if (!window.indexedDB && /Safari/.test(navigator.userAgent)) return true;
                } catch (e) { return true; }

                return false;
            }

            // Perform check silently
            const status = await detectIncognito();
            hiddenInput.value = status ? 'true' : 'false';
        })();
      </script>
      <div class="mb-4">
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <button type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
        Login
      </button>
      
      <div class="mt-4">
          <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center bg-white border border-gray-300 text-gray-700 py-2 rounded hover:bg-gray-50 transition shadow-sm">
              <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
              </svg>
              Login with Google
          </a>
      </div>
    </form>

    <p class="text-sm text-gray-600 text-center mt-4">
      Don’t have an account? 
      <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
    </p>
  </div>
</section>
@endsection
