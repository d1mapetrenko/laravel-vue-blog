require('./bootstrap');
require('admin-lte');

window.Vue = require('vue');

Vue.component('posts', require('./components/Posts.vue'));

const app = new Vue({
    el: '#app'
});