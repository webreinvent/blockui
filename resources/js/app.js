require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
Vue.use(VueResource);



Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

Vue.config.async = false;

import VueHelpers from './VueHelpers';

Vue.use(VueHelpers);


Vue.component('bui-nav', require('./components/BuiNavComponent.vue'));


const app = new Vue({
    el: '#app'
});

