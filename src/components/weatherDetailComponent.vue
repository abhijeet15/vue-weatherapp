<template>
  <section class="closest">
    <div class="row weather weather-sml">

      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <h2>
          
            {{ cityName() }}
        </h2>
        
      </div>
      <weather v-for="record in model" :propObj="record" propPage="details"></weather>

    </div>
    <button class="btn btin0-danger" @click="close">Close</button>
    </section>
</template>

<script>

import { mapState, mapActions } from 'vuex';
import weather from './weatherComponent.vue';

export default {

  mounted( ){

      let _tmp = JSON.stringify(this.weather_data.collection[ this.$route.params.woeid ]);
      if( _tmp == JSON.stringify( [ ] ) || typeof _tmp ==  "undefined" )
      {
          alert( "Direct access to this page not allowed, redirecting to Home Page" );
          this.$router.push( "/" )
      }
  },
    components: 
    {
        weather
    },

  computed:{
      ...mapState( [ 'weather_data' ] ),

      model( )
      {
        
        return this.weather_data.collection[ this.$route.params.woeid ].consolidated_weather;
      },
  },

  methods:
  {
      cityName(){
        return this.weather_data.collection[ this.$route.params.woeid ].title
      },

      close(){
        window.history.go(-1)
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
