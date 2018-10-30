
export default {

	state: {
		default_cities_data: [ ],
		collection: [ ],
		model: [],
		filters:[ ],
		error_msg: [],
		success_msg: null
	},

	getters: {

	},

	actions: {

		

		/*mapCity( { state },id ){

		let self = this;
		return new Promise( function( resolve, reject ){

		let x = _.filter( self.state.page_data.collection, function(o) { return ( o.id == id ); });

		if( x.length > 0 )
		resolve( x[ 0 ] );
		else
		{
		console.log( "could not filter given input" );
		resolve( { } )
		}


		} )


		},*/

		/*showError( context, msg )
		{
		    context.commit( 'UPDATE_ERROR_MSG', msg );
		    context.commit( 'UPDATE_SUCCESS_MSG', null );

		    setTimeout( function() { context.commit( 'UPDATE_ERROR_MSG', { } ) }, 6000 );
		}*/

		set_default_cities( context, data )
		{
			context.commit( 'UPDATE_DEFAULT_CITIES_DATA', data );
		},

		set_search_cities( context, data )
		{
			context.commit( 'UPDATE_COLLECTION_DATA', data );
		}

	},

	mutations: {

		UPDATE_DEFAULT_CITIES_DATA(state, payload) {

			state.default_cities_data = payload;

		},

		UPDATE_COLLECTION_DATA(state, payload) {

			state.collection = payload;

		}
	}
}
