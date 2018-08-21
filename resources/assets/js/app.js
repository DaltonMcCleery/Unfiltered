
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Buefy from 'buefy'
import 'buefy/lib/buefy.css'

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '331481405b7c80c36cc1',
    cluster: 'us2',
    encrypted: true
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Buefy);

Vue.component('available-games', require('./components/AvailableGames.vue'));
Vue.component('lobby', require('./components/Lobby.vue'));

const app = new Vue({
    el: '#app'
});
