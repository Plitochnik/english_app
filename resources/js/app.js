import './bootstrap';

import { createApp } from 'vue';


const app = createApp({});


import ContactForm from "./components/ContactForm.vue";
import HeadComponent from "./components/HeadComponent.vue";

app.component('head-component', HeadComponent);
app.component('contact-form', ContactForm);


app.mount('#app');
