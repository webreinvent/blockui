require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueResource from 'vue-resource';

Vue.use(VueResource);
Vue.use(VueRouter);

Vue.config.delimiters = ['@{{', '}}'];

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

Vue.config.async = false;



import VueHelpers from './VueHelpers';
Vue.use(VueHelpers);

import Left from './components/Left';
import Home from './components/Home';
import Blocks from './components/Blocks';
import Block from './components/Block';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/blocks/:category',
            component: Blocks,
            props: (route) => ({
                query: route.query,
                segments: route.params
            })

        },
        {
            path: '/blocks/:category/:name',
            component: Block,
            props: (route) => ({
                query: route.query,
                segments: route.params
            })

        },
    ]
});

const app = new Vue({
    el: '#app',
    components:{
        'left': Left
    },
    router,
    data: {
        searched: 'searched'
    },
    mounted() {

    },
    methods:{

        //-----------------------------------------------------------
        //-----------------------------------------------------------
        getTypedInput: function (e) {
            console.log('occ');

            this.searched = e;

        },
        //-----------------------------------------------------------
        appOnClick: function (e) {

            console.log('asdf');

        }
        //-----------------------------------------------------------
        //-----------------------------------------------------------
    }
});