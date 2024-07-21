import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Vue3Toastify, {toast} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import {createPinia} from "pinia";
const pinia = createPinia()
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(Vue3Toastify, {
                autoClose: 3000,
                closeButton: true,
                hideProgressBar: false,
                position: toast.POSITION.BOTTOM_RIGHT,
                pauseOnHover: true,
                multiple: false,
                theme: "colored"
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
