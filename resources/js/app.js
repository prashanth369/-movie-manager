
import Vue from "vue";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'



// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import '../css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import App from "./vue/app.vue";

const app = new Vue({
    el: "#app",
    components: { App },
});