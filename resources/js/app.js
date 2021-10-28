require('./bootstrap');
window.baseUrl = "http://localhost/mini-crm-laravel-vue/public/api"

import Vue from 'vue'
import routes from './routes'

export const EventBus = new Vue();

window.onload = function() {
	const app = new Vue({
	    el: '#app',
	    router: routes
	});
}


 