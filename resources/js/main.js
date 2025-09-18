import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './vue/App.vue';
import Home from './vue/pages/Home.vue';
import Voucher from './vue/pages/Voucher.vue';
import Accounts from './vue/pages/Accounts.vue';

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/home', redirect: { name: 'home' } },
    { path: '/voucher', name: 'voucher', component: Voucher },
    { path: '/jual-akun', name: 'accounts', component: Accounts },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() { return { top: 0 }; },
});

createApp(App).use(router).mount('#app');


