import './bootstrap';
import { createApp } from 'vue';



const app = createApp({});

import ParamForm from "./components/Form/ParamForm.vue";


app.component('param-form', ParamForm);


app.mount('#app');
