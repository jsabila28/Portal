<?php
// Define an array to store routes (similar to Laravel routes)
$routes = [
	'' => '/pages/dashboard.php',
	'/' => '/pages/dashboard.php',
	'/dashboard' => '/pages/dashboard.php',
	'/login' => '/Portal/main/pages/login.php',
	'/sji' => '/pages/sji.php',
	'/so' => '/pages/so.php',

	'/personal' => '/actions/personal.php',
	//PAGES
	'/fam' => '/pages/family_background.php'

	
];

// Get the current request URI (remove the base URL if needed)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim(str_replace("/Portal/profile", "", $uri), "#");

// top
if(isset($routes[$uri]) && strpos($routes[$uri], "pages/") !== false) include_once($portal_root."/layout/atd_top.php");

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
	// Get the corresponding script file
	$script = $sr_root.$routes[$uri];
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