import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
// element plus
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

// sweatalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// datepicker
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import VueApexCharts from 'vue3-apexcharts';

import ApexTooltipStyle from './apexchart-style';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props)})

        app.use(plugin)
        app.use(ZiggyVue)
        app.use(ElementPlus)
        app.use(VueSweetalert2)
        app.use(VueApexCharts)
        app.component('VueDatePicker', VueDatePicker);
        window.Swal = app.config.globalProperties.$swal
        app.directive('apex-tooltip-style', ApexTooltipStyle);
        app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
});
