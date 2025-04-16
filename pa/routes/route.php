<?php
// Define an array to store routes (similar to Laravel routes)
$routes = [
	'' => '/pages/dashboard.php',
	'/' => '/pages/dashboard.php',
	'/dashboard' => '/pages/dashboard.php',
	'/login' => '/pages/login.php',
	'/pa' => '/pages/pa.php',
	'/savepa' => '/actions/pa.php',
	'/pasummary' => '/pages/pa-summary.php',
	'/PA_summary' => '/pages/PAsummary.php'
	
];

// Get the current request URI (remove the base URL if needed)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim(str_replace("/Portal/pa", "", $uri), "#");

// top
if(isset($routes[$uri]) && strpos($routes[$uri], "pages/") !== false) include_once($portal_root."/layout/patop.php");

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
	// Get the corresponding script file
	$script = $pa_root.$routes[$uri];
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
if(isset($routes[$uri]) && strpos($routes[$uri], "pages/") !== false) include_once($portal_root."/layout/bottom.php");