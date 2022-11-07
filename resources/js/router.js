import { createRouter, createWebHistory} from "vue-router";
import Home from "./Pages/_Home/Home.vue";
import ParamForm from "./Pages/Form/ParamForm.vue";
import SignIn from "./Pages/Register/Sign-In.vue";



const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/start', name: Home, component: Home },
        { path: '/paramform', name: ParamForm, component: ParamForm },
        { path: '/register', name: SignIn, component: SignIn },
    ]
})

export default router;
