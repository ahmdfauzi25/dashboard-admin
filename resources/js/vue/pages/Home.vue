<template>
  <section>
    <div class="relative bg-[#0f0f0f]">
      <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div>
            <h1 class="text-3xl md:text-4xl font-bold">Top Up Voucher Game & Jual Akun</h1>
            <p class="text-gray-400 mt-3">Cepat, aman, harga bersaing. Login diperlukan saat checkout voucher.</p>
            <div class="mt-6 flex gap-3">
              <router-link to="/voucher" class="px-4 py-2 rounded bg-orange-500 text-black font-semibold">Top Up Sekarang</router-link>
              <router-link to="/jual-akun" class="px-4 py-2 rounded border border-[#333]">Cari Akun</router-link>
            </div>
          </div>
          <div>
            <img :src="hero" alt="preview" class="rounded-lg border border-[#222]" />
          </div>
        </div>
      </div>
    </div>
    <div class="max-w-6xl mx-auto px-4 py-12">
      <h2 class="text-xl font-semibold mb-4">Produk Terbaru</h2>
      <ProductGrid />
    </div>
  </section>
</template>

<script setup>
import ProductGrid from '../shared/ProductGrid.vue';
const hero = '/img/dashboard.png';
</script>


