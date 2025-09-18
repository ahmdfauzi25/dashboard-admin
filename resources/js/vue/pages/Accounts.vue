<template>
  <section class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Jual Akun</h1>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
      <div v-for="item in accounts" :key="item.id" class="border border-[#222] rounded-lg p-4 bg-[#121212]">
        <div class="font-semibold">{{ item.title }}</div>
        <div class="text-sm text-gray-400 mt-2" v-if="item.description">{{ item.description }}</div>
        <div class="mt-3 font-bold">{{ rupiah(item.price) }}</div>
        <a :href="whatsappUrl(item)" target="_blank" class="mt-4 inline-block px-3 py-1 rounded bg-green-500 text-black font-medium">Chat Admin</a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const accounts = ref([]);

function rupiah(v){
  if(v == null) return '-';
  return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(v);
}
function whatsappUrl(item){
  const phone = import.meta.env.VITE_ADMIN_WA || '6281234567890';
  const text = encodeURIComponent(`[JUAL AKUN] ${item.title} - ${rupiah(item.price)}`);
  return `https://wa.me/${phone}?text=${text}`;
}

onMounted(async () => {
  const res = await fetch('/api/jual-accounts');
  accounts.value = await res.json();
});
</script>


