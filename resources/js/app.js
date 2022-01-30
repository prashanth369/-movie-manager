import Vue from "vue";
import Router from "vue-router";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import addMovieForm from "./vue/addMovieForm";
import listMovie from "./vue/listMovie";
import movieView from "./vue/movieView";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(Router);

const routes = [
    {
        path: "/",
        component: listMovie
    },
    {
        path: "/update/:id",
        component: addMovieForm
    },
    {
        path: "/add",
        component: addMovieForm
    },
    {
        path: "/movie/:id",
        component: movieView
    }
];

const router = new Router({ routes });
import "../css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import App from "./vue/app.vue";

const app = new Vue({
    el: "#app",
    router,
    render: h => h(App)
});