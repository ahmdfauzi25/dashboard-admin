<template>
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <div v-for="p in products" :key="p.id" class="border border-[#222] rounded-lg overflow-hidden bg-[#121212]">
      <div class="aspect-[4/3] bg-[#1a1a1a]">
        <img v-if="p.image_url" :src="p.image_url" alt="img" class="w-full h-full object-cover" />
      </div>
      <div class="p-3">
        <div class="font-semibold leading-tight">{{ p.name }}</div>
        <div class="mt-1 text-sm text-gray-400">Voucher/Game</div>
        <div class="mt-2 font-bold">{{ rupiah(p.price) }}</div>
        <a href="/login" class="mt-3 inline-block px-3 py-1 rounded bg-orange-500 text-black text-sm font-medium">Beli</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
const products = ref([]);

function rupiah(v){
  return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v||0);
}

onMounted(async () => {
  const res = await fetch('/api/products');
  products.value = await res.json();
});
</script>


