<?php
/**
 * This script mirrors metaweather API.
 * It offers two commands:
 *
 * command: search
 * uri: weather.php?command=search&keyword={your_keyword}
 * 
 * command: location
 * uri: weather.php?command=location&woeid={target_woeid}
 */

/**
 * Declarations
 */
$validCommands = [
	'search',
	'location',
	'search_multiple'
];

$command = isset($_GET['command']) ? $_GET['command'] : null;
$baseUrl = 'https://www.metaweather.com/api/location/';

/**
 * Functions
 */
function quitWithResponse($output, $code = 200) {
	header('Content-Type: text/json');
	header("Access-Control-Allow-Origin: *");
	http_response_code($code);
	echo $output;
	exit;
}

function quitWithJsonResponse($output, $code = 200) {
	return quitWithResponse(
		json_encode($output),
		$code
	);
}

function mirrorToEndpoint($uri) {
	global $baseUrl;
	$response = @file_get_contents($baseUrl . $uri);
	
	if ( $response ) {
		return quitWithResponse($response);	
	}	
	
	quitWithJsonResponse(['error' => 'Not found'], 404);
}

function mirrorToEndpoint_multiple($uri) {
	global $baseUrl;
	$response = @file_get_contents($baseUrl . $uri);
	
	if ( $response ) {
		return $response;	
	}	
	
	return json_encode( [ 'error' => 'Not found']);
}

function requireParameters($params) {
	foreach ($params as $param) {
		if (!isset($_GET[$param])) {
			quitWithJsonResponse(['error' => $param . ' is missing']);
		}
	}
}

/**
 * Commands
 */
function search_multiple() {

	$response = [ ];

	requireParameters(['keyword']);

	if( ! empty( $_GET['keyword'] ) )
	{
		$woeids = [ ];
		$keywords = explode( ",", $_GET['keyword'] );
		foreach ( $keywords as $keyword) {
			$response1 =  mirrorToEndpoint_multiple('search/?query=' . trim($keyword));
			$response1 = json_decode( $response1, true );
			
			if( empty( $response1[ 'error' ] ) )
			{
				foreach ($response1 as $city_info)
				{
					if( ! empty( $city_info[ 'woeid' ] ) )
					{
						$response2 = json_decode( mirrorToEndpoint_multiple( $city_info[ 'woeid' ] ), true );
						if( empty( $response2[ 'error' ] ) )
							$response[ $city_info[ 'woeid' ] ] = $response2;
					}
					
				}
			}
			
		}
	}
	if( empty( $response ) )
		quitWithJsonResponse(['error' => 'Not found'], 404);
	else
		quitWithResponse( json_encode( $response ) );
}

function search() {
	requireParameters(['keyword']);
	return mirrorToEndpoint('search/?query=' . $_GET['keyword']);
}

function location() {
	requireParameters(['woeid']);
	return mirrorToEndpoint($_GET['woeid']);
}

/**
 * Execution
 */
if (is_null($command) or !in_array($command, $validCommands)) {
	quitWithJsonResponse(['error' => 'Invalid command'], 422);
}

$command();