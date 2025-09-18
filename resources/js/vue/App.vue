<template>
  <div class="min-h-screen bg-[#111] text-white">
    <header class="sticky top-0 z-20 bg-[#111] border-b border-[#222]">
      <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <router-link to="/" class="font-bold text-orange-500">HiddenGame</router-link>
        <nav class="flex items-center gap-4 text-sm">
          <router-link to="/" class="hover:text-orange-400">Home</router-link>
          <router-link to="/voucher" class="hover:text-orange-400">Top Up</router-link>
          <router-link to="/jual-akun" class="hover:text-orange-400">Jual Akun</router-link>
          <a href="/login" class="ml-2 px-3 py-1 rounded bg-orange-500 hover:bg-orange-600 text-black font-medium">Login</a>
        </nav>
      </div>
    </header>

    <router-view />

    <footer class="border-t border-[#222] mt-12">
      <div class="max-w-6xl mx-auto px-4 py-8 text-xs text-gray-400">© {{ new Date().getFullYear() }} HiddenGame Clone</div>
    </footer>
  </div>

</template>

<script setup>
</script>

<style>
/* gunakan util tailwind bawaan welcome untuk sementara */
</style>


