require('./bootstrap');

import Vue from 'vue'
import routes from './routes'

export const EventBus = new Vue();

window.onload = function() {
	const app = new Vue({
	    el: '#app',
	    router: routes
	});
}


 
