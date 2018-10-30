<template>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" data-date="2018-10-30">

  <template v-if="propPage == 'search'">
    <h5><a @click="go_details">{{ propObj.cityname }}</a></h5>
  </template>
  <template v-else>
    <h5><a>{{ getDay( ) }}</a></h5>
  </template>

  <dl>

    <dd class="weatherstate" data-original-title="" title="">
      <div class="state-icon-sml state-c"><img :src="weather_icon( )" style="width:32px"></div>
      <span class="hidden-xs hidden-sm">Clear</span>
    </dd>

    <dd>
      Temp: {{ propObj.the_temp.toFixed( 2 ) }}&#8451;<br />
      Max: {{ propObj.max_temp.toFixed( 2 ) }}&#8451;<br />
      Min: {{ propObj.min_temp.toFixed( 2 ) }}&#8451;
    </dd>
  </dl>
</div>
</template>

<script>

  import { mapState, mapActions } from 'vuex';
  
  export default {
    //name: 'Welcome to Weather Liting page',
    props: {
      // type, required and default are optional, you can reduce it to 'options: Object'
      propObj: { type: Object, required: true, default: { }},
      propPage: { type: String, required: true, default: "search"},
    },
    methods:{

        weather_icon( )
        {
            return "https://www.metaweather.com/static/img/weather/" + this.propObj.weather_state_abbr+ ".svg";
        },

        getDay( )
        {
            var j = new Array( "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" );
            let date = new Date( this.propObj.applicable_date );
            return j[ date.getDay( ) ];
        },

        go_details( )
        {
          this.$router.push( "/weather/" + this.propObj.woeid );
        }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
