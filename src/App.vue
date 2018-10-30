<template>
  <div id="app">
    <div class="col-md-10 col-md-offset-1">
        <div class="col-md-10 pull-left">
          <h1 class="text-left">{{app}}</h1>
        </div>
        <div class="col-md-2 pull-right">
          <router-link to="/">Home</router-link>
        </div>
        <div style="clear: both;"></div>
    <hr />
    <p class="text-left">This app internally uses MetaWether.com REST api's to display weather.</p>
    <hr>
    <router-view></router-view> 
    </div>
  </div>
</template>

<script>
import weatherListComponent from './components/weatherListComponent.vue'
import weatherDetailComponent from './components/weatherDetailComponent.vue'
import { mapState, mapActions } from 'vuex';
export default {
  name: 'app',
  components: {
    weatherListComponent,
    weatherDetailComponent,
  },
  mounted( ){
    // this.defaultListing( 'Istanbul,Berlin,London,Helsinki,Dublin,Vancouver' );
  },

  methods : {

    /*defaultListing( param ) {
      this.$http.get('http://127.0.0.1:8092/vue-weatherapp/api/weather.php?command=search_multiple&keyword=Istanbul,Berlin,London,Helsinki,Dublin,Vancouver').then((response) => {
              // success callback
              alert( response )
              console.log( response )
          }, (response) => {
              // error callback
              console.error(response);
              //this.loading = false;
          });
    }*/
  },
  computed:
  {
      ...mapState( [ 'app' ] ),
      page_title( ){
        return this.app;
      }
  }
}
</script>

<style>
  @import './assets/css/bootstrap.min.css';
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /*margin-top: 60px;*/
}
</style>
