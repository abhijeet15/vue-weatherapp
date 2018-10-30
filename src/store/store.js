import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
Vue.use(require('vue-resource'));

import weather_data from './../modules/weather.js';

export const store = new Vuex.Store({
	modules: {
		weather_data
	},
	state : {
		app: "Weather App",
		default_home_page_cities: 'Istanbul,Berlin,London,Helsinki,Dublin,Vancouver',
		api_url_multi_search: "http://127.0.0.1:8092/vue-weatherapp/api/weather.php?command=search_multiple&keyword="
	}
});