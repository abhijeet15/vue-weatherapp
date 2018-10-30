import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import App from './App.vue'
import VueResource from 'vue-resource'
import { store } from './store/store';

import Home from './components/weatherListComponent.vue'
import WeatherDetails from './components/weatherDetailComponent.vue'

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueResource)

const routes = [
	{
		path : "/search/:keyword",
		component: Home
	},
	{
		path : "/weather/:woeid",
		component: WeatherDetails
	},
	{
		path : "/",
		component: Home
	}

];

const router = new VueRouter({
	routes,
	// mode:"history"
});
// send the request as application/x-www-form-urlencoded
Vue.http.options.emulateJSON = true;

new Vue({
	store : store,
	router : router,
	el: '#app',
	render: h => h(App)
})
