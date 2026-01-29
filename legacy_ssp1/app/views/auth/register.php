<?php

ob_start();
?>
<!-- Back Button -->
<div class="mb-6">
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
<section class="flex justify-center items-center min-h-screen bg-gray-50">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="index.php?route=register">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 mb-1">Full Name</label>
        <input type="text" id="name" name="name" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="mb-4">
        <label for="confirm" class="block text-gray-700 mb-1">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" required
          class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
      </div>
      <button type="submit"
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
        Register
      </button>
    </form>

    <p class="text-sm text-gray-600 text-center mt-4">
      Already have an account?
      <a href="index.php?route=auth.login" class="text-blue-600 hover:underline">Login</a>
    </p>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
