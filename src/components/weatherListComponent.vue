<template>
    
        <div id="idx-page-listing">

            
            <div v-if='weather_data.error_msg.length' class="alert alert-danger">
              {{weather_data.error_msg}}
            </div>

            <div class="panel-body">
            
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th style="text-align: right;" colspan="5">
                    <span class="pull-left" style="font-size: 24px;">Weather Report(s)</span>
                    <form @submit.prevent="do_search" class="form-inline pull-right">
                      <input class="form-control mr-sm-2" type="text" placeholder="Search by city name" aria-label="Search" v-model="filters.cityname">
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    </th>
                  </tr>
                </thead>
                <tbody>
                  
                  <template v-if="has_records">
                      <tr>
                    <td colspan="5">
                      <weather v-for="record in collection" :propObj="record" propPage="search"></weather>
                      </td>
                    </tr> 
                  </template>
                  <template v-else-if="loading">
                      <tr >
                        <td colspan="100%"><img alt="Loading..." style="height:24px;"  src="./../assets/ajax-loader.gif"></td>
                      </tr>
                  </template>
                  <template v-else="has_records == false">
                      <tr >
                        <td colspan="100%">No results were found. Try changing the keyword!</td>
                      </tr>
                  </template>

                  
                      
                </tbody>
              </table>
            </form>
            </div>
        </div>
</template>

<script>

  import { mapState, mapActions } from 'vuex';
  import weather from './weatherComponent.vue';
  
  export default {
    //name: 'Welcome to Weather Liting page',
    props: {
      msg: String
    },

    data( ) {
      return {
        loading : false,
        requestType: "default"
      }
    },
    components: 
    {
        weather
    },
    watch:
    {
      '$route' (to,from){
        this.search( to.params.keyword );
      }

    },

    mounted( ){
      this.search( this.$route.params.keyword );
    },
    computed:
    {
            ...mapState( [ 'app', 'weather_data', 'api_url_multi_search', 'default_home_page_cities' ] ),

            has_records( ){
              return this.collection.length > 0
            },

            collection( ){
              
              var c = [ ];
              let data = this.weather_data.collection;
              for( var x in data )
              {
                let weather = data[ x ][ 'consolidated_weather' ][0];
                weather.woeid = x;
                weather.cityname = data[ x ].title;
                c.push( weather );

              }
              return c;
            },

            filters( ){

                  return this.weather_data.filters;
            }
    },
    methods:{

      ...mapActions( [ 'set_default_cities', 'set_search_cities' ] ),

      do_search( )
      {
          this.$router.push( "/search/" + this.filters.cityname );
      },

      search( params ){
        
        var _self = this;

        if( ! params )
        {

            // -- if homw page data is already loaded.
            if( JSON.stringify(this.weather_data.default_cities_data) != JSON.stringify( [ ] ) ){
              this.set( this.weather_data.default_cities_data );
              this.filters.cityname = "";
              return;
            }
            // -- after this.set(), because not to set again same data.
            this.requestType == "default";

            params = this.default_home_page_cities;
        }
        else
        {
            this.requestType = "search";
            this.set_search_cities( [ ] );
        }



        this.loading = true;
        this.find( _self.api_url_multi_search + params )
        .then(function(result) {
            _self.set( JSON.parse( result ) );
        })
        .catch( function( error ) {
            _self.set( [ ] );
        });
      },

      set( data ){
        this.loading = false;

        if( this.requestType == "default" ){
          this.set_default_cities( data );
        }
        
        this.set_search_cities( data );
      },

      find( url )
      {
        return new Promise(function(resolve, reject) {
              let req = new XMLHttpRequest();
              req.open("GET", url);
              req.onload = function() {
                  if (req.status === 200) {
                      resolve(req.response);
                  } else {
                      reject(new Error(req.statusText));
                  }
              };
              req.onerror = function() {
                  reject(new Error("Network error"));
              };
              req.send();
        });
      }
    }

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.table th{
  text-align: center;
}
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
