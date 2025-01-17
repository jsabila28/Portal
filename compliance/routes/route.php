<?php
// Define an array to store routes (similar to Laravel routes)
$routes = [
	'' => '/pages/dashboard.php',
	'/' => '/pages/dashboard.php',
	'/dashboard' => '/pages/dashboard.php',
	'/login' => '/pages/login.php',
	'/ir' => '/pages/incident-report.php',
	'/phoneA' => '/pages/phone-agreement.php',
	'/13A' => '/pages/13A.php',
	'/13B' => '/pages/13B.php',
	'/ircreate' => '/pages/create_ir.php',
	'/_13Acreate' => '/pages/create_13A.php',
	'/checked13a' => '/pages/open_checked13a.php',


	'/13_a' => '/actions/get13A.php',
	'/posted13_a' => '/actions/_13Aposted.php',
	'/checked13_a' => '/actions/_13Achecked.php',
	'/reviewed13_a' => '/actions/_13Areviewed.php',
	'/issued13_a' => '/actions/_13Aissued.php',
	'/needexp13_a' => '/actions/_13Aneedexp.php',
	'/cancel13_a' => '/actions/_13Acancel.php',
	'/13_b' => '/actions/get13B.php',
	'/globe_pa' => '/actions/PA_globe.php',

	'/incidentReport' => '/actions/get_ir.php',
	'/postIR' => '/actions/posted-ir.php',
	'/draftIR' => '/actions/draft-ir.php',
	'/solvedIR' => '/actions/resolved-ir.php',
	'/explIR' => '/actions/explain-ir.php',
	'/IRopen' => '/pages/open-ir.php',
	'/_13Aopen' => '/pages/open-13A.php',
	'/saveIR' => '/actions/save_ir.php',
	'/savedraftIR' => '/actions/save_irdraft.php',
	'/IRsign' => '/actions/sign-ir.php',
	'/irRemark' => '/actions/save_ir_remark.php',
	'/_13aRemark' => '/actions/save_13a_remark.php',
	'/cancel' => '/actions/cancel_13a.php',
	'/notedBysave' => '/actions/save_noted_by.php',
	'/stateSave' => '/actions/save_statement.php'
	
];

// Get the current request URI (remove the base URL if needed)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim(str_replace("/Portal/compliance", "", $uri), "#");

// top
if(isset($routes[$uri]) && strpos($routes[$uri], "pages/") !== false) include_once($portal_root."/layout/comtop.php");

// Check if the requested URI exists in the routes array
if (array_key_exists($uri, $routes)) {
	// Get the corresponding script file
	$script = $com_root.$routes[$uri];
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