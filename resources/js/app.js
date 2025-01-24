import '../css/app.css';
import './bootstrap';

import {createInertiaApp,Link} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {createApp, h} from 'vue';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
        app.use(plugin)
        app.use(ZiggyVue)
        app.use(PrimeVue, {
            theme: {
                preset: Aura
            }
        });
        app.component('DefaultLayout',DefaultLayout);
        app.component('Link', Link)
        app.mount(el);
        return app
    },
    progress: {
        color: '#4B5563',
    },
});
