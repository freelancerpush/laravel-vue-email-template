
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import viewTemplate from "./components/ViewCountComponent.vue";
import manageTemplate from "./components/AddTemplateComponent.vue";
// const viewTemplate = require("./components/ViewCountCompnent.vue");
// const addTemplate = require("./components/AddTemplateCompnent.vue");
const router = new VueRouter({
  routes: [
    { path:'/',component:manageTemplate },
    { path:'/show-count',component:viewTemplate },
  ]
})
var Editor = require('@tinymce/tinymce-vue').default;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('modal', {
  template: '#modal-template'
})

var app = new Vue({
  router,
  el: '#vue-wrapper',
  components: {
    'tinymce-editor': Editor, // <- Important part
  },
});