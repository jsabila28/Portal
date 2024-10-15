<?php
// Define an array to store routes (similar to Laravel routes)
$routes = [
	'' => 'main/pages/dashboard.php',
	'/' => 'main/pages/dashboard.php',
	'/dashboard' => 'main/pages/dashboard.php',
	'/login' => 'main/pages/login.php',
	'/signIn' => 'main/actions/signIn.php',
	'/getUser' => 'main/actions/get_user.php',
	'/signOut' => 'main/actions/logout.php',

	'/reaction' => 'main/actions/save_reaction.php',
	'/postnews' => 'main/actions/post_news.php',

	// DASHBOARD
	'/holiday' => 'main/actions/holiday.php',
	'/post' => 'main/actions/postfeed.php',
	'/legal' => 'main/actions/gov_ann.php'

];
// Get the current request URI (remove the base URL if needed)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim(str_replace("/Portal", "", $uri), "#");
// top
if(isset($routes[$uri]) 
	&& strpos($routes[$uri], "main/pages/") !== false 
	&& $_SERVER['REQUEST_URI'] != '/Portal/login') {
	include_once($portal_root."/layout/top.php");
}

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
	// Get the corresponding script file
	$script = $routes[$uri];
	// print_r($script);
	
	// Extract any GET parameters from the URL
	parse_str($_SERVER['QUERY_STRING'], $queryParams);
	
	// Include the script file and pass the GET parameters as variables
	require_once $script;
	// extract($queryParams);
	
} else {
	// Handle cases where the route is not found (e.g., display a 404 page)
	echo "<h1>404 Not Found</h1>";
}

// bottom
if(isset($routes[$uri]) 
	&& strpos($routes[$uri], "main/pages/") !== false
	&& $_SERVER['REQUEST_URI'] != '/Portal/login') {
	include_once($portal_root."/layout/bottom.php");
}