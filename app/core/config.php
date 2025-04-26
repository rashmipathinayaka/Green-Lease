<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	/** database config **/
	define('DBNAME', 'green_lease_new');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	// define('DBNAME', 'sasmitha_green_lease');
	// define('DBHOST', 'mysql-sasmitha.alwaysdata.net');
	// define('DBUSER', 'sasmitha');
	// define('DBPASS', 'greenlease@123');
	// define('DBDRIVER', '');

	define('ROOT', dirname(dirname(__FILE__)));
	define('URLROOT', 'http://localhost/Green-Lease/public');
} else {
	/** database config **/
	define('DBNAME', 'sasmitha_green_lease');
	define('DBHOST', 'mysql-sasmitha.alwaysdata.net');
	define('DBUSER', 'sasmitha');
	define('DBPASS', 'greenlease@123');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');
}

define('APP_NAME', "My Website");
define('APP_DESC', "Best website on the planet");

/** true means show errors **/
define('DEBUG', true);

// Error handling for production
if (!DEBUG) {
	error_reporting(0);
	ini_set('display_errors', '0');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

// Stripe Configuration removed
// Your Stripe API Keys removed
// For localhost, use the webhook secret from Stripe CLI removed
