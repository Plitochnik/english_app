import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Lara from '@/presets/lara';

// prime vue styles
import 'primevue/resources/themes/aura-light-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';

// prime vue components
import PrimeVue from 'primevue/config';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FloatLabel from "primevue/floatlabel";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin}) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)
            .use(PrimeVue, {
                // unstyled: true,
                // pt: Lara
            })
            .component('Dialog', Dialog)
            .component('Button', Button)
            .component('InputText', InputText)
            .component('FloatLabel', FloatLabel)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
