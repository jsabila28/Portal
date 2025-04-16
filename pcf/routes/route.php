<?php
// Define an array to store routes (similar to Laravel routes)
$routes = [
	'' => '/pages/dashboard.php',
	'/' => '/pages/dashboard.php',
	'/dashboard' => '/pages/dashboard.php',
	'/login' => '/pages/login.php',

	'/replenish_list' => '/pages/replenish_list.php',
	'/disbursment' => '/pages/disbursment_view.php',
	'/Replenish' => '/pages/replenish.php',
	'/disburse' => '/pages/disbursement.php',
	'/coh' => '/pages/cash_on_hand.php',
	'/setup' => '/pages/set_up_pcf.php',

	'/save_entry' => '/actions/save_entry.php',
	'/update_entry' => '/actions/update_entry.php',
	'/check_pcv' => '/actions/check_pcv.php',
	'/get_last_entry' => '/actions/get_last_entry.php',
	'/get_custodian_dept' => '/actions/get_custodian_dept.php',
	'/save_attachment' => '/actions/save_attachment.php',
	'/fetch_attachment' => '/actions/fetch_attachment.php',
	'/save_replenish' => '/actions/save_replenish.php',
	'/update_disburse' => '/actions/update_disburse.php',
	'/update_COH' => '/actions/update_cash_on_hand.php',
	'/save_comment' => '/actions/save_message.php',
	'/cancel_row' => '/actions/cancel_entry.php',
	'/get_disburse' => '/actions/get_disburse.php'
	
];

// Get the current request URI (remove the base URL if needed)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim(str_replace("/Portal/pcf", "", $uri), "#");

// top
if(isset($routes[$uri]) && strpos($routes[$uri], "pages/") !== false) include_once($portal_root."/layout/pcf_top.php");

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
	// Get the corresponding script file
	$script = $pcf_root.$routes[$uri];
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